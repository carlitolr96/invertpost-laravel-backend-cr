<?php

namespace Tests\Unit;

use App\Models\TblPedido;
use App\Models\TblCliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TblPedidoControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test the index method (list all pedidos).
     */
    public function test_index_pedidos(): void
    {
        TblPedido::factory(3)->create();

        $response = $this->getJson('/api/pedidos');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data', 'total', 'per_page', 'current_page', 'last_page'])
                 ->assertJsonCount(3, 'data');
    }

    /**
     * Test the store method (create a new pedido).
     */
    public function test_store_pedido(): void
    {
        $cliente = TblCliente::factory()->create(); // Create a cliente
        $pedidoData = [
            'ClienteId' => $cliente->ClienteId,
            'fecha_pedido' => $this->faker->date(),
        ];

        $response = $this->postJson('/api/pedidos', $pedidoData);

        $response->assertStatus(201)
                 ->assertJson(['ClienteId' => $pedidoData['ClienteId']]);

        $this->assertDatabaseHas('tblpedidos', ['ClienteId' => $pedidoData['ClienteId']]);
    }

    /**
     * Test the store method with validation errors.
     */
    public function test_store_pedido_validation_error(): void
    {
        $response = $this->postJson('/api/pedidos', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['ClienteId', 'fecha_pedido']);
    }

    /**
     * Test the show method (get a specific pedido).
     */
    public function test_show_pedido(): void
    {
        $pedido = TblPedido::factory()->create();

        $response = $this->getJson("/api/pedidos/{$pedido->PedidoId}");

        $response->assertStatus(200)
                 ->assertJson(['ClienteId' => $pedido->ClienteId]);
    }

    /**
     * Test the show method with an invalid ID.
     */
    public function test_show_pedido_not_found(): void
    {
        $response = $this->getJson('/api/pedidos/999');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Pedido no encontrado']);
    }

    /**
     * Test the update method (update a pedido).
     */
    public function test_update_pedido(): void
    {
        $pedido = TblPedido::factory()->create();
        $cliente = TblCliente::factory()->create();

        $updatedData = ['ClienteId' => $cliente->ClienteId];

        $response = $this->putJson("/api/pedidos/{$pedido->PedidoId}", $updatedData);

        $response->assertStatus(200)
                 ->assertJson(['ClienteId' => $updatedData['ClienteId']]);

        $this->assertDatabaseHas('tblpedidos', ['PedidoId' => $pedido->PedidoId, 'ClienteId' => $updatedData['ClienteId']]);
    }

    /**
     * Test the update method with validation errors.
     */
    public function test_update_pedido_validation_error(): void
    {
        $pedido = TblPedido::factory()->create();

        $response = $this->putJson("/api/pedidos/{$pedido->PedidoId}", ['ClienteId' => 999]); // Invalid ClienteId

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['ClienteId']);
    }

    /**
     * Test the destroy method (delete a pedido).
     */
    public function test_destroy_pedido(): void
    {
        $pedido = TblPedido::factory()->create();

        $response = $this->deleteJson("/api/pedidos/{$pedido->PedidoId}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Pedido eliminado']);

        $this->assertDatabaseMissing('tblpedidos', ['PedidoId' => $pedido->PedidoId]);
    }

    /**
     * Test the destroy method with an invalid ID.
     */
    public function test_destroy_pedido_not_found(): void
    {
        $response = $this->deleteJson('/api/pedidos/999');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Pedido no encontrado']);
    }

    /**
     * Test the index method with filters.
     */
    public function test_index_pedidos_with_filters(): void
    {
        $cliente = TblCliente::factory()->create();
        TblPedido::factory()->create(['ClienteId' => $cliente->ClienteId, 'fecha_pedido' => '2024-01-10']);
        TblPedido::factory()->create(['ClienteId' => $cliente->ClienteId, 'fecha_pedido' => '2024-01-15']);

        $response = $this->getJson("/api/pedidos?ClienteId={$cliente->ClienteId}&fecha_pedido=2024-01-10");

        $response->assertStatus(200)
                 ->assertJsonCount(1, 'data')
                 ->assertJsonPath('data.0.fecha_pedido', '2024-01-10 00:00:00');
    }

    /**
     * Test the index method with pagination.
     */
    public function test_index_pedidos_with_pagination(): void
    {
        TblPedido::factory(12)->create();

        $response = $this->getJson('/api/pedidos?per_page=5');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data', 'total', 'per_page', 'current_page', 'last_page'])
                 ->assertJsonCount(5, 'data');
    }
}