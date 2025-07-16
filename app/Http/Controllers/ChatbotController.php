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
        $confidence = $request->input('confidence', 'medium');

        if (empty($userMessage)) {
            return response()->json(['error' => 'Message cannot be empty.'], 400);
        }

        // Count the number of user questions in history
        $questionCount = collect($history)
            ->where('role', 'user')
            ->filter(
                fn($msg) =>
                isset($msg['parts'][0]['text']) &&
                    str_ends_with(trim($msg['parts'][0]['text']), '?')
            )->count();

        // Dynamically adjust confidence level
        if ($questionCount >= 10 && $confidence !== 'low') {
            $confidence = 'low';
        } elseif ($questionCount >= 5 && $confidence === 'high') {
            $confidence = 'medium';
        }

        // Set tone instruction based on confidence
        $toneInstruction = match ($confidence) {
            'low' => "The user is a complete beginner. Be extremely gentle, patient, and encouraging. Avoid any technical jargon. Validate their concerns. Do not use ",
            'medium' => "The user has some cooking experience. Use a friendly and supportive tone. Assume basic understanding of cooking terms. Explain tips clearly and offer help when needed.",
            'high' => "The user is confident and experienced. Use a concise, expert tone. Offer advanced tips, use technical language when appropriate, and keep explanations efficient unless asked.",
            default => "Be friendly and helpful."
        };

        // Start the conversation with tone instructions if no history
        if (empty($history)) {
            $history[] = [
                'role' => 'user',
                'parts' => [[
                    'text' => "You are a recipe assistant. Respond in exactly 1 complete sentence. Do not exceed this limit. $toneInstruction"
                ]]
            ];
        }

        // Add current user message to history
        $instruction = "Start with short words of encouragement then respond in exactly 1 complete sentence. Do not exceed this limit.";
        $history[] = [
            'role' => 'user',
            'parts' => [['text' => $userMessage . $instruction]]
        ];
        $payload = ['contents' => $history];

        $apiKey = env('GEMINI_API_KEY', '');
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($apiUrl, $payload);

            $responseData = $response->json();

            Log::info('Gemini API raw response:', ['response' => $responseData]);

            if (
                $response->successful() &&
                isset($responseData['candidates'][0]['content']['parts'][0]['text'])
            ) {
                $rawText = $responseData['candidates'][0]['content']['parts'][0]['text'];
                $botResponseText = preg_replace('/(\*\*|__)(.*?)\1/', '$2', $rawText); // remove bold
                $botResponseText = preg_replace('/(\*|_)(.*?)\1/', '$2', $botResponseText); // remove italic
                
                // Append bot response to history
                $history[] = [
                    'role' => 'model',
                    'parts' => [['text' => $botResponseText]]
                ];

                return response()->json([
                    'response' => $botResponseText,
                    'history' => $history,
                    'confidence' => $confidence
                ]);
            } else {
                Log::error('Gemini API Error:', [
                    'response' => $responseData,
                    'status' => $response->status()
                ]);
                return response()->json(['error' => 'Failed to get a response from the chatbot. Please try again later.'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Chatbot API Request Exception:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An unexpected error occurred. Please try again.'], 500);
        }
    }
}
