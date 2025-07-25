<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Recipe;
use Inertia\Inertia;

class RecipesController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $level = 'medium'; // default

        if ($user && $user->level_value !== null) {
            if ($user->level_value <= 33) {
                $level = 'low';
            } elseif ($user->level_value <= 66) {
                $level = 'medium';
            } else {
                $level = 'high';
            }
        }

        // Define ordering based on user level
        $order = match ($level) {
            'low' => ['Easy', 'Medium', 'Hard'],
            'medium' => ['Medium', 'Hard', 'Easy'],
            'high' => ['Hard', 'Medium', 'Easy'],
            default => ['Medium', 'Hard', 'Easy'],
        };


        Log::info('User Level:', ['user' => $user?->id, 'level_value' => $user?->level_value, 'calculated_level' => $level]);
        Log::info('Ordering:', ['order' => $order]);

        $recipes = Recipe::orderByRaw("
        CASE 
            WHEN difficult = ? THEN 1
            WHEN difficult = ? THEN 2
            WHEN difficult = ? THEN 3
            ELSE 4
        END
    ", $order)->get();

        Log::info('Recipes fetched:', ['count' => $recipes->count(), 'difficulties' => $recipes->pluck('difficult')]);

        return Inertia::render('Home', [
            'recipes' => $recipes
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
