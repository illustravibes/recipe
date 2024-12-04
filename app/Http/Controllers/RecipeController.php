<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Ingredient;
use Inertia\Inertia;
use App\Models\Recipe;

class RecipeController extends Controller
{

    public function index()
    {
        $recipes = Recipe::with(['category', 'ingredients'])->get();
        $categories = Category::all();
        $ingredients = Ingredient::all();
    
        return Inertia::render('Recipe/Index', [
            'recipes' => $recipes,
            'categories' => $categories,
            'ingredients' => $ingredients,
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        $ingredients = Ingredient::all();
        return Inertia::render('Recipe/Create', [
            'categories' => $categories,
            'ingredients' => $ingredients,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'ingredients' => 'required|array',
            'ingredients.*' => 'exists:ingredients,id',
        ]);
        
        $category = Category::findOrFail($validated['category_id']);

        $recipe = Recipe::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'category_id' => $validated['category_id'],
            'category_name' => $category->name,
        ]);

        $recipe->ingredients()->sync($validated['ingredients']);

        return redirect()->route('recipe.index');
    }
}
