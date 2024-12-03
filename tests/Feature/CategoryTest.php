<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_one(): void
    {
        $data = ['name' => 'Desserts'];

        $response = $this->postJson('api/categories', $data);

        $response->assertStatus(201)
        ->assertJsonFragment(['name' =>'Desserts']);
        $this->assertDatabaseHas('categories', $data);
    }

    public function test_get_many(): void
    {
        Category::factory()->count(2)->create();

        $response = $this->getJson('api/categories');

        $response->assertStatus(200)
            ->assertJsonCount(2);
    }

    public function test_get_one(): void
    {
       $category = Category::factory()->create();

        $response = $this->getJson("api/categories/{$category->id}");

        $response->assertStatus(200)
            ->assertJson(['name' => $category->name]);
    }

    public function test_update_one(): void
    {
        $category = Category::factory()->create();
        $data = ['name' => 'Updated Category'];

        $response = $this->putJson("api/categories/{$category->id}", $data);

        $response->assertStatus(200)
            ->assertJson(['name' => 'Updated Category']);

        $this->assertDatabaseHas('categories', $data);
    }

    public function test_delete_one(): void
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson("api/categories/{$category->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
