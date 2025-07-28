<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    public function store(Request $request)
    {
        $answers = $request->input('answers'); // associative array of integers 0–5

        // Convert to flat array of numeric values
        $numericAnswers = array_map('intval', array_values($answers));
        $count = count($numericAnswers);

        if ($count === 0) {
            return response()->json(['error' => 'No answers provided'], 400);
        }

        // Calculate mean on a 0–5 scale
        $mean = array_sum($numericAnswers) / $count;

        // Scale to 0–100
        $scaledValue = ($mean / 5) * 100;

        

        // Save to user
        $user = Auth::user();
        $user->level_value = round($scaledValue, 2); // 0–100
        $user->has_onboarded = true;
        $user->save();
    }
}
