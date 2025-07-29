<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class ChatbotController extends Controller
{
    private function getYouTubeVideoLink($query)
    {
        $apiKey = env('YOUTUBE_API_KEY');
        $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&maxResults=1&q=" . urlencode($query) . "&key={$apiKey}";

        try {
            $response = Http::get($url)->json();
            if (!empty($response['items'][0]['id']['videoId'])) {
                $videoId = $response['items'][0]['id']['videoId'];
                return "https://www.youtube.com/watch?v={$videoId}";
            }
        } catch (\Exception $e) {
            Log::error('YouTube API Error: ' . $e->getMessage());
        }
        return null;
    }

    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        $userMessage = $request->input('message');
        $history = $request->input('history', []);
        $confidenceInput = $request->input('confidence');
        $context = $request->input('context', 'Chat');
        $recipe = $request->input('recipe'); //receive the selected recipe
        $step  = $request->input('step');
        Log::info('Incoming recipe payload:', ['recipe' => $recipe, 'step' => $step]);


        if (empty($userMessage)) {
            return response()->json(['error' => 'Message cannot be empty.'], 400);
        }

        $videoLink = null;
        if (preg_match('/(video|youtube|tutorial)/i', $userMessage)) {
            // Build a search query using recipe + step context
            $searchQuery = $recipe['name'] ?? 'cooking tutorial';
            if (is_numeric($step) && $step > -1 && isset($recipe['steps'][$step])) {
                $searchQuery .= " - " . $recipe['steps'][$step];
            }
            $videoLink = $this->getYouTubeVideoLink($searchQuery);
        }


        $apiKey = env('GEMINI_API_KEY', '');
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        $confidence = 'medium'; // Default fallback

        // --- Always run confidence analysis ---
        $confidencePrompt = <<<EOT
Rate the user's confidence about their cooking ability from 0 to 100. 

- 0–20: Extremely low confidence (e.g., "I'm scared", "I can't do this", "I'm lost").
- 21–40: Low confidence (e.g., "I'm unsure", "I need help").
- 41–60: Moderate confidence (e.g., "I'm okay", "I'm managing").
- 61–80: High confidence (e.g., "I can do this", "I'm doing well").
- 81–100: Extremely high confidence (e.g., "That was easy", "I'm great at this").

User message: "{$userMessage}"

Return **only a single integer** between 0 and 100.
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
                $rawConfidence = trim($confidenceData['candidates'][0]['content']['parts'][0]['text']);
                Log::info('Raw confidence response:', ['raw' => $rawConfidence]);

                $score = (int)$rawConfidence;
                $score = max(0, min($score, 100)); // Clamp to 0–100

                Log::info('Parsed confidence score:', ['score' => $score]);

                if ($score <= 33) {
                    $confidence = 'low';
                } elseif ($score <= 66) {
                    $confidence = 'medium';
                } else {
                    $confidence = 'high';
                }

                Log::info('Final confidence label:', ['confidence' => $confidence]);

                if ($user) {
                    $alpha =  0.15;
                    $previousScore = $user->level_value ?? 50;
                    $newScore = $alpha * $score + (1 - $alpha) * $previousScore;

                    $user->level_value = $newScore;
                    $user->save();
                }
            }
        } catch (\Exception $e) {
            Log::warning('Confidence classification failed:', ['message' => $e->getMessage()]);
        }


        $toneInstruction = match ($confidence) {
            'low' => "The user is a complete beginner. Be extremely gentle, patient, and encouraging. Avoid any technical jargon. Validate their concerns.",
            'medium' => "The user has some cooking experience. Use a friendly and supportive tone. Assume basic understanding of cooking terms. Explain tips clearly and offer help when needed.",
            'high' => "The user is confident and experienced. Use a concise, expert tone. Offer advanced tips, use technical language when appropriate, and keep explanations efficient unless asked.",
            default => "Be friendly and helpful."
        };



        $recipeIntro = "No recipe provided.";
        if (isset($recipe['name'])) {
            $stepText = '';
            if (is_numeric($step) && $step > -1 && isset($recipe['steps'][$step])) {
                $stepText = "You're currently on step " . ($step + 1) . ": {$recipe['steps'][$step]}";
            } else {
                $stepText = "Steps: " . implode(" | ", $recipe['steps']) . ".";
            }

            $recipeIntro = "The user is currently cooking: {$recipe['name']}. " .
                "Here is the description: {$recipe['description']} " .
                "Ingredients: " . implode(", ", $recipe['ingredients']) . ". " .
                $stepText;
        }


        Log::info('Incoming recipe payload:', ['recipe Intro' => $recipeIntro]);


        $history[] = [
            'role' => 'user',
            'parts' => [[
                'text' => "You are a recipe assistant. $toneInstruction\n\n$recipeIntro"
            ]]
        ];


        // Append user message with a soft instruction
        $instruction = "Start with encouragement. Limit empathic response to 1 sentence only.  Be concise.";
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

                if ($videoLink) {
                    $botResponseText .= "\n\nHere's a helpful video tutorial: " . $videoLink;
                }


                $history[] = [
                    'role' => 'model',
                    'parts' => [['text' => $botResponseText]]
                ];

                return response()->json([
                    'response' => $botResponseText,
                    'history' => $history,
                    'confidence' => $confidence,
                    'video' => $videoLink
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

    public function sendFeedback(Request $request)
    {
        $user = Auth::user();
        $userMessage = $request->input('message');
        $history = $request->input('history', []);
        $recipe = $request->input('recipe');
        $step  = $request->input('step');
        $context = 'Recipe Feedback';

        if (empty($userMessage)) {
            return response()->json(['error' => 'Feedback cannot be empty.'], 400);
        }

        $apiKey = env('GEMINI_API_KEY', '');
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        $confidence = 'medium';

        // --- Confidence analysis ---
        $confidencePrompt = <<<EOT
Analyze the following user message and return a numeric confidence score between 0 and 100, where 0 is low confidence, 100 is high confidence. Do NOT include any words, symbols, or explanations — only output the number.

Message: "{$userMessage}"
EOT;

        $confidencePayload = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [['text' => $confidencePrompt]]
                ]
            ]
        ];

        try {
            $confidenceResponse = Http::withHeaders(['Content-Type' => 'application/json'])->post($apiUrl, $confidencePayload);
            $confidenceData = $confidenceResponse->json();

            if ($confidenceResponse->successful() && isset($confidenceData['candidates'][0]['content']['parts'][0]['text'])) {
                $rawConfidence = trim($confidenceData['candidates'][0]['content']['parts'][0]['text']);
                $score = max(0, min((int)$rawConfidence, 100));

                $confidence = $score <= 33 ? 'low' : ($score <= 66 ? 'medium' : 'high');

                Log::info("Confidence score: $score");

                if ($user) {
                    $alpha = 0.4; // Feedback updates confidence more strongly
                    $previousScore = $user->level_value ?? 50;
                    $user->level_value = $alpha * $score + (1 - $alpha) * $previousScore;

                    $user->save();
                }
            }
        } catch (\Exception $e) {
            Log::warning('Confidence classification failed (feedback):', ['message' => $e->getMessage()]);
        }

        // Tone adjustment
        $toneInstruction = match ($confidence) {
            'low' => "The user is a complete beginner. Be gentle and encouraging.",
            'medium' => "The user has some experience. Be friendly and supportive.",
            'high' => "The user is confident. Be concise and expert.",
            default => "Be friendly and helpful."
        };

        // Build recipe context
        $recipeIntro = "No recipe provided.";
        if (isset($recipe['name'])) {
            $stepText = (is_numeric($step) && $step > -1 && isset($recipe['steps'][$step]))
                ? "You're currently on step " . ($step + 1) . ": {$recipe['steps'][$step]}"
                : "Steps: " . implode(" | ", $recipe['steps']) . ".";
            $recipeIntro = "The user is providing feedback about: {$recipe['name']}. Description: {$recipe['description']} Ingredients: " . implode(", ", $recipe['ingredients']) . ". " . $stepText;
        }

        // Prepend context
        $history[] = [
            'role' => 'user',
            'parts' => [['text' => "You are a recipe assistant receiving feedback. $toneInstruction\n\n$recipeIntro"]]
        ];

        // Append user feedback
        $history[] = [
            'role' => 'user',
            'parts' => [['text' => $userMessage . "\nAcknowledge their feedback in a polite and concise way."]]
        ];

        // Final Gemini API call
        try {
            $payload = ['contents' => $history];
            $response = Http::withHeaders(['Content-Type' => 'application/json'])->post($apiUrl, $payload);
            $responseData = $response->json();

            if ($response->successful() && isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                $botResponseText = preg_replace('/(\*\*|__|\*|_)(.*?)\1/', '$2', $responseData['candidates'][0]['content']['parts'][0]['text']);
                $history[] = ['role' => 'model', 'parts' => [['text' => $botResponseText]]];

                return redirect('/Home');
            } else {
                Log::error('Gemini API Error (feedback):', ['response' => $responseData, 'status' => $response->status()]);
                return response()->json(['error' => 'Failed to process feedback.'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Chatbot Feedback API Exception:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An unexpected error occurred while processing feedback.'], 500);
        }
    }
}
