<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function sendMessage(Request $request)
    {
        $userMessage = $request->input('message');
        $history = $request->input('history', []);
        $confidenceInput = $request->input('confidence');
        $recipe = $request->input('recipe'); //receive the selected recipe
        Log::info('Incoming recipe payload:', ['recipe' => $recipe]);


        if (empty($userMessage)) {
            return response()->json(['error' => 'Message cannot be empty.'], 400);
        }

        $apiKey = env('GEMINI_API_KEY', '');
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        $confidence = 'medium'; // Default fallback

        if (!is_null($confidenceInput)) {
            $confidencePrompt = <<<EOT
Classify the following user message as 'low', 'medium', or 'high' confidence. Only reply with one of these words and nothing else.

Examples:
Low: "I don't know what to do", "I'm lost", "I think I messed up", "I'm feeling stuck"
Medium: "That was okay", "I did alright", "I'm not sure"
High: "That was easy", "I nailed it", "I'm confident", "I want more"

Message: "{$userMessage}"
EOT;

            $confidencePayload = [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => $confidencePrompt]
                        ]
                    ]
                ]
            ];

            try {
                $confidenceResponse = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->post($apiUrl, $confidencePayload);

                $confidenceData = $confidenceResponse->json();

                if (
                    $confidenceResponse->successful() &&
                    isset($confidenceData['candidates'][0]['content']['parts'][0]['text'])
                ) {
                    $classified = strtolower(trim($confidenceData['candidates'][0]['content']['parts'][0]['text']));
                    if (in_array($classified, ['low', 'medium', 'high'])) {
                        $confidence = $classified;
                    }
                }
            } catch (\Exception $e) {
                Log::warning('Confidence classification failed:', ['message' => $e->getMessage()]);
            }
        }

        $toneInstruction = match ($confidence) {
            'low' => "The user is a complete beginner. Be extremely gentle, patient, and encouraging. Avoid any technical jargon. Validate their concerns.",
            'medium' => "The user has some cooking experience. Use a friendly and supportive tone. Assume basic understanding of cooking terms. Explain tips clearly and offer help when needed.",
            'high' => "The user is confident and experienced. Use a concise, expert tone. Offer advanced tips, use technical language when appropriate, and keep explanations efficient unless asked.",
            default => "Be friendly and helpful."
        };

        // 👇 Inject recipe context only once at the start of the conversation
        if (empty($history)) {
    $recipe = $request->input('recipe');
    
    $recipeIntro = isset($recipe['name']) 
        ? "The user is currently cooking: {$recipe['name']}. " .
          "Here is the description: {$recipe['description']} " .
          "Ingredients: " . implode(", ", $recipe['ingredients']) . ". " .
          "Steps: " . implode(" | ", $recipe['steps']) . "."
        : "No recipe provided.";

    $history[] = [
        'role' => 'user',
        'parts' => [[
            'text' => "You are a recipe assistant. $toneInstruction\n\n$recipeIntro"
        ]]
    ];
    }

        // Append user message with a soft instruction
        $instruction = "Start with encouragement. Respond in 1–3 complete sentences.";
        $history[] = [
            'role' => 'user',
            'parts' => [['text' => $userMessage . "\n" . $instruction]]
        ];

        // Final Gemini API call
        $payload = ['contents' => $history];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($apiUrl, $payload);

            $responseData = $response->json();

            if (
                $response->successful() &&
                isset($responseData['candidates'][0]['content']['parts'][0]['text'])
            ) {
                $rawText = $responseData['candidates'][0]['content']['parts'][0]['text'];

                // Clean markdown styling
                $botResponseText = preg_replace('/(\*\*|__)(.*?)\1/', '$2', $rawText); // bold
                $botResponseText = preg_replace('/(\*|_)(.*?)\1/', '$2', $botResponseText); // italic

                $history[] = [
                    'role' => 'model',
                    'parts' => [['text' => $botResponseText]]
                ];

                return response()->json([
                    'response' => $botResponseText,
                    'history' => $history,
                    'confidence' => $confidenceInput !== null ? $confidence : null
                ]);
            } else {
                Log::error('Gemini API Error:', [
                    'response' => $responseData,
                    'status' => $response->status()
                ]);
                return response()->json(['error' => 'Failed to get a response from the chatbot. Please try again later.'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Chatbot API Exception:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }
}
