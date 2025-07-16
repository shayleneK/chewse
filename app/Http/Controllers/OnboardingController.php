<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    public function store(Request $request)
{
    $answers = $request->input('answers'); // an associative array of integers

    // Convert to flat array of numeric values
    $numericAnswers = array_map('intval', array_values($answers));
    $count = count($numericAnswers);

    if ($count === 0) {
        return response()->json(['error' => 'No answers provided'], 400);
    }


    $mean = array_sum($numericAnswers) / $count;

    $level = match (true) {
    $mean < 2.5 => 'Beginner',
    $mean < 4.0 => 'Intermediate',
    default     => 'Advanced',
};

    $user = Auth::user();
    $user->level_value = round($mean, 2);
    $user->level = $level;
    $user->has_onboarded = true;
    $user->save();

    
}

}
