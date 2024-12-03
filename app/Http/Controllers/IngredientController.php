<?php

namespace App\Http\Controllers;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ingredients = Ingredient::all();
        return Inertia::render('Ingredient/Index', [
            'ingredients' => $ingredients,
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'amount' => 'required|integer',
            'unit' => 'required|string',
        ]);
        $ingredient = Ingredient::create($validated);
        return redirect()->route('ingredient.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ingredient = Ingredient::findOrFail($id);
        return response()->json($ingredient);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ingredient = Ingredient::findOrFail($id);
        $ingredient->update([
            'name' => $request->name,
            'amount' => $request->amount,
            'unit' => $request->unit
        ]);
        return response()->json($ingredient);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ingredient = INgredient::findOrFail($id);
        $ingredient->delete();
        return redirect()->route('ingredient.index');
    }
}
