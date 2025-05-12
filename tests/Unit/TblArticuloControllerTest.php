<?php

namespace Tests\Unit;

use App\Models\TblArticulo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TblArticuloControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker; // Reset DB after each test, use Faker for data

    /**
     * Test the index method (list all articulos).
     */
    public function test_index_articulos(): void
    {
        TblArticulo::factory(3)->create(); // Create 3 articulos for testing

        $response = $this->getJson('/api/articulos');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data', 'total', 'per_page', 'current_page', 'last_page'])
                 ->assertJsonCount(3, 'data');
    }

    /**
     * Test the store method (create a new articulo).
     */
    public function test_store_articulo(): void
    {
        $articuloData = [
            'descripcion' => $this->faker->sentence,
            'fabricante' => $this->faker->company,
            'codigo_barras' => '1234567890',
            'precio' => $this->faker->randomFloat(2, 10, 100),
            'stock' => $this->faker->numberBetween(1, 100),
        ];

        $response = $this->postJson('/api/articulos', $articuloData);

        $response->assertStatus(201)
                 ->assertJson(['descripcion' => $articuloData['descripcion']]);

        $this->assertDatabaseHas('tblarticulos', ['codigo_barras' => $articuloData['codigo_barras']]);
    }

    /**
     * Test the store method with validation errors.
     */
    public function test_store_articulo_validation_error(): void
    {
        $response = $this->postJson('/api/articulos', []); // Empty data

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['descripcion', 'fabricante', 'codigo_barras', 'precio', 'stock']);
    }

    /**
     * Test the show method (get a specific articulo).
     */
    public function test_show_articulo(): void
    {
        $articulo = TblArticulo::factory()->create();

        $response = $this->getJson("/api/articulos/{$articulo->ArticuloId}");

        $response->assertStatus(200)
                 ->assertJson(['descripcion' => $articulo->descripcion]);
    }

    /**
     * Test the show method with an invalid ID.
     */
    public function test_show_articulo_not_found(): void
    {
        $response = $this->getJson('/api/articulos/999');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Artículo no encontrado']);
    }

    /**
     * Test the update method (update an articulo).
     */
    public function test_update_articulo(): void
    {
        $articulo = TblArticulo::factory()->create();

        $updatedData = ['descripcion' => 'Updated Description'];

        $response = $this->putJson("/api/articulos/{$articulo->ArticuloId}", $updatedData);

        $response->assertStatus(200)
                 ->assertJson(['descripcion' => $updatedData['descripcion']]);

        $this->assertDatabaseHas('tblarticulos', ['ArticuloId' => $articulo->ArticuloId, 'descripcion' => $updatedData['descripcion']]);
    }

    /**
     * Test the update method with validation errors.
     */
    public function test_update_articulo_validation_error(): void
    {
        $articulo = TblArticulo::factory()->create();

        $response = $this->putJson("/api/articulos/{$articulo->ArticuloId}", ['descripcion' => '']); // Empty descripcion

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['descripcion']);
    }

    /**
     * Test the destroy method (delete an articulo).
     */
    public function test_destroy_articulo(): void
    {
        $articulo = TblArticulo::factory()->create();

        $response = $this->deleteJson("/api/articulos/{$articulo->ArticuloId}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Artículo eliminado']);

        $this->assertDatabaseMissing('tblarticulos', ['ArticuloId' => $articulo->ArticuloId]);
    }

    /**
     * Test the destroy method with an invalid ID.
     */
    public function test_destroy_articulo_not_found(): void
    {
        $response = $this->deleteJson('/api/articulos/999');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Artículo no encontrado']);
    }

    /**
     * Test the index method with filters.
     */
    public function test_index_articulos_with_filters(): void
    {
        TblArticulo::factory()->create(['descripcion' => 'Camisa', 'precio' => 20, 'stock' => 10]);
        TblArticulo::factory()->create(['descripcion' => 'Pantalon', 'precio' => 30, 'stock' => 5]);
        TblArticulo::factory()->create(['descripcion' => 'Zapatos', 'precio' => 50, 'stock' => 2]);

        $response = $this->getJson('/api/articulos?nombre=Camisa&precio_min=15&precio_max=25&stock_min=8');

        $response->assertStatus(200)
                 ->assertJsonCount(1, 'data')
                 ->assertJsonPath('data.0.descripcion', 'Camisa');
    }

    /**
     * Test the index method with pagination.
     */
    public function test_index_articulos_with_pagination(): void
    {
        TblArticulo::factory(12)->create();

        $response = $this->getJson('/api/articulos?per_page=5');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data', 'total', 'per_page', 'current_page', 'last_page'])
                 ->assertJsonCount(5, 'data');
    }
}