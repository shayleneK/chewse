<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function classifyConfidence(Request $request)
    {
        $review = $request->input('review');
        if (empty($review)) {
            return response()->json(['error' => 'Review cannot be empty.'], 400);
        }

        $prompt = <<<EOT
        Classify the following user review as 'low', 'neutral', or 'high' confidence. Only reply with one of these words and nothing else.

        Examples:
        Low: "I did bad", "I didn't know what to do", "I'm feeling lost", "I messed up", "I'm discouraged"
        Neutral: "That was ok", "I did fine"
        High: "I did great", "That was easy", "I learned a lot", "I want to do more"

        Review: "$review"
        EOT;
        
        $apiKey = env('GEMINI_API_KEY', '');
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";
        $payload = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($apiUrl, $payload);

            $responseData = $response->json();
            Log::info('Gemini API review response:', ['response' => $responseData]);

            if (
                $response->successful() &&
                isset($responseData['candidates'][0]['content']['parts'][0]['text'])
            ) {
                $confidence = strtolower(trim($responseData['candidates'][0]['content']['parts'][0]['text']));
                if (!in_array($confidence, ['low', 'neutral', 'high'])) {
                    $confidence = 'unknown';
                }
                return response()->json(['confidence' => $confidence]);
            } else {
                return response()->json(['error' => 'Failed to classify confidence.'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Review API Exception:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }
}