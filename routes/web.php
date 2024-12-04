<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;

use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Index');
})->name('index');

Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
Route::post('/categories', [CategoryController::class, 'create'])->name('category.create');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
Route::post('/categories', [CategoryController::class, 'store'])->name('category.store');
Route::put('/categories', [CategoryController::class, 'update'])->name('category.update');

Route::get('/ingredients', [IngredientController::class, 'index'])->name('ingredient.index');
Route::post('/ingredients/create', [IngredientController::class, 'create'])->name('ingredient.create');
Route::delete('/ingredients/{id}', [IngredientController::class, 'destroy'])->name('ingredient.destroy');
Route::post('/ingredients', [IngredientController::class, 'store'])->name('ingredient.store');
Route::put('/ingredients', [IngredientController::class, 'update'])->name('ingredient.update');

Route::get('/recipes', [RecipeController::class, 'index'])->name('recipe.index');
Route::post('/recipes', [RecipeController::class, 'store'])->name('recipe.store');
require __DIR__.'/auth.php';
