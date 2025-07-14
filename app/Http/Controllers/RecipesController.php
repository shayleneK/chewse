<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use Inertia\Inertia;

class RecipesController extends Controller
{
    public function index()
    {
        $recipes = Recipe::all();
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
