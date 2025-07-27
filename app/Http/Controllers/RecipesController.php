<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Recipe;
use Inertia\Inertia;

class RecipesController extends Controller
{
   public function index(Request $request)
{
    $user = auth()->user();
    $level = 'medium';

    if ($user && $user->level_value !== null) {
        if ($user->level_value < 2.5 ) {
            $level = 'beginner';
        } elseif ($user->level_value < 4.0 ) {
            $level = 'advanced';
        } else {
            $level = 'master';
        }
    }

    $order = match ($level) {
        'beginner' => ['Easy', 'Medium', 'Hard'],
        'advanced' => ['Medium', 'Hard', 'Easy'],
        'master' => ['Hard', 'Medium', 'Easy'],
        default => ['Medium', 'Hard', 'Easy'],
    };

    $difficultyFilter = $request->query('difficulty');

    $query = Recipe::query();

    if (in_array($difficultyFilter, ['Easy', 'Medium', 'Hard'])) {
        $query->where('difficult', $difficultyFilter);
    }

    $recipes = $query->orderByRaw("
        CASE 
            WHEN difficulty = ? THEN 1
            WHEN difficulty = ? THEN 2
            WHEN difficulty = ? THEN 3
            ELSE 4
        END
    ", $order)->get();

    $popupMessage = null;
    $redirectRecipeId = null;

    $options = match ($level) {
        'beginner' => ['challenge', 'none'],
        'advanced' => ['challenge', 'easy', 'none'],
        'master' => ['easy', 'none'],
        default => ['none'],
    };

    $random = $options[array_rand($options)];

    // Determine popup message
    $popupMessage = match ($random) {
        'challenge' => 'Want a challenge? Try a harder recipe!',
        'easy' => 'Wanna take it easy? Let\'s try a simpler recipe.',
        default => null,
    };

    $currentDifficulty = $order[0]; // Current level
$harderDifficulty = $order[1];  // One level harder
$easierDifficulty = $order[2];  // One level easier


    // Choose target difficulty for redirection
    $targetDifficulty = match ($random) {
    'challenge' => $harderDifficulty,
    'easy' => $easierDifficulty,
    default => null,
};

    if ($targetDifficulty) {
    $targetRecipe = Recipe::where('difficult', $targetDifficulty)->inRandomOrder()->first();
    if ($targetRecipe) {
        $redirectRecipeId = $targetRecipe->id;
    }
}


    return Inertia::render('Home', [
        'recipes' => $recipes,
        'selectedDifficulty' => $difficultyFilter,
        'popupMessage' => $popupMessage,
        'redirectRecipeId' => $redirectRecipeId, // Pass this to Vue
    ]);
}





    public function show($id)
    {
        $recipe = Recipe::find($id);
        return Inertia::render('Recipe', [
            'recipe' => $recipe
        ]);
    }
}
