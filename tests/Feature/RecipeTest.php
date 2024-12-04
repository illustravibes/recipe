<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Recipe;
use App\Models\Ingredient;

class RecipeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_get_many(): void
    {
        $category = Category::factory()->create();
        $recipes = Recipe::factory()->count(10)->create([
            'category_id' => $category->id,
        ]);
        $response = $this->getJson('/api/recipes');
        $response->assertStatus(200)
            ->assertJsonCount(10, 'data');
    }

    public function test_create_one(): void
    {
        $ingredients = Ingredient::factory()->count(3)->create();

        $recipe = Recipe::factory()->create();
        $recipe->ingredients()->sync($ingredients->pluck('id')->toArray());

        $this->assertDatabaseHas('recipes', [
        'id' => $recipe->id,
        'name' => $recipe->name,
    ]);
    }
}
