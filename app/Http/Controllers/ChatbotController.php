<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 

class ChatbotController extends Controller
{
    /**
     * Handle incoming chat messages and get a response from the Gemini API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(Request $request)
    {
        $userMessage = $request->input('message');

        if (empty($userMessage)) {
            return response()->json(['error' => 'Message cannot be empty.'], 400);
        }

        // Define the empathic persona for the chatbot
        $prompt = "You are an empathic and supportive recipe assistant. Your goal is to help users with their cooking journey, provide encouragement, and offer helpful tips and solutions in a kind and understanding manner. When users describe a problem or ask for help, respond with empathy, validate their feelings, and then offer practical, supportive advice.\n\nUser: " . $userMessage;

        // Prepare the payload for the Gemini API
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

        // Replace with your actual Gemini API Key.
        // It's highly recommended to store API keys in your .env file
        // and access them using env('GEMINI_API_KEY').
        $apiKey = env('GEMINI_API_KEY', ''); // Make sure to set GEMINI_API_KEY in your .env

        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($apiUrl, $payload);

            $responseData = $response->json();

            // Check for successful response and extract the bot's text
            if ($response->successful() && isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                $botResponseText = $responseData['candidates'][0]['content']['parts'][0]['text'];
                return response()->json(['response' => $botResponseText]);
            } else {
                // Log the error for debugging
                \Log::error('Gemini API Error:', ['response' => $responseData, 'status' => $response->status()]);
                return response()->json(['error' => 'Failed to get a response from the chatbot. Please try again later.'], 500);
            }
        } catch (\Exception $e) {
            // Log any exceptions
            \Log::error('Chatbot API Request Exception:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An unexpected error occurred. Please try again.'], 500);
        }
    }
}
