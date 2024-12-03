<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Ingredient;
use Tests\TestCase;

class IngredientTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_one(): void
    {
        $data = [
            'name' => 'Butter',
            'amount' => 1,
            'unit' => 'kilogram'
        ];

        $response = $this->postJson('api/ingredients', $data);

        $response->assertStatus(201)
        ->assertJsonFragment(['name' =>'Butter']);
        $this->assertDatabaseHas('ingredients', $data);
    }

    public function test_get_many(): void
    {
        Ingredient::factory()->count(2)->create();

        $response = $this->getJson('api/ingredients');

        $response->assertStatus(200)
            ->assertJsonCount(2);
    }

    public function test_get_one(): void
    {
       $ingredient = Ingredient::factory()->create();

        $response = $this->getJson("api/ingredients/{$ingredient->id}");

        $response->assertStatus(200)
            ->assertJson([
                'name' => $ingredient->name,
                'amount' => $ingredient->amount,
                'unit' => $ingredient->unit
            ]);
    }

    public function test_update_one(): void
    {
        $ingredient = Ingredient::factory()->create();
        $data = [
            'name' => 'Updated Ingredient',
             'amount' => 5,
                'unit' => 'kg'
        ];

        $response = $this->putJson("api/ingredients/{$ingredient->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'name' => 'Updated Ingredient',
        ]);

        $this->assertDatabaseHas('ingredients', $data);
    }

    public function test_delete_one(): void
    {
        $ingredient = Ingredient::factory()->create();

        $response = $this->deleteJson("api/ingredients/{$ingredient->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('ingredients', ['id' => $ingredient->id]);
    }
}
