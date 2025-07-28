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
    $showPopup = false;
    $popupType = null;
    $level = 'beginner';

    if ($user && $user->level_value !== null) {
        $value = $user->level_value;

        if ($value < 40) {
            $level = 'beginner';
            // close to leveling up
            if ($value >= 40 - 15) {
                $showPopup = true;
                $popupType = 'challenge';
            }
        } elseif ($value < 80) {
            $level = 'advanced';

            if ($value >= 80 - 15) {
                $showPopup = true;
                $popupType = 'challenge'; // close to master
            } elseif ($value <= 40 + 15) {
                $showPopup = true;
                $popupType = 'easy'; // close to beginner
            }
        } else {
            $level = 'master';

            if ($value <= 80 + 15) {
                $showPopup = true;
                $popupType = 'easy'; // close to advanced
            }
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
        $query->where('difficulty', $difficultyFilter);
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

    if ($showPopup && $popupType !== null) {
        $popupMessage = match ($popupType) {
            'challenge' => 'You’re almost ready for the next level! Want to try a harder recipe?',
            'easy' => 'Wanna take it easy? Try an easier recipe!',
            default => null,
        };

        $currentDifficulty = $order[0];
        $harderDifficulty = $order[1];
        $easierDifficulty = $order[2];

        $targetDifficulty = match ($popupType) {
            'challenge' => $harderDifficulty,
            'easy' => $easierDifficulty,
            default => null,
        };

        if ($targetDifficulty) {
            $targetRecipe = Recipe::where('difficulty', $targetDifficulty)->inRandomOrder()->first();
            if ($targetRecipe) {
                $redirectRecipeId = $targetRecipe->id;
            }
        }
    }

    return Inertia::render('Home', [
        'recipes' => $recipes,
        'selectedDifficulty' => $difficultyFilter,
        'popupMessage' => $popupMessage,
        'redirectRecipeId' => $redirectRecipeId,
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
