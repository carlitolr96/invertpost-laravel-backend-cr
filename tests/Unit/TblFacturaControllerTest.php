<?php

namespace Tests\Unit\app\Http\Controllers;

use App\Models\TblFactura;
use App\Models\TblPedido;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TblFacturaControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index_facturas(): void
    {
        TblFactura::factory(3)->create();

        $response = $this->getJson('/api/facturas');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['FacturaId', 'PedidoId', 'monto_total', 'fecha_factura']
                ],
                'total',
                'per_page',
                'current_page',
                'last_page',
            ]);
    }

    public function test_store_factura(): void
    {
        $pedido = TblPedido::factory()->create();
        $facturaData = [
            'PedidoId' => $pedido->PedidoId,
            'monto_total' => $this->faker->randomFloat(2, 50, 500),
            'fecha_factura' => $this->faker->dateTimeThisMonth->format('Y-m-d H:i:s'),
        ];

        $response = $this->postJson('/api/facturas', $facturaData);

        $response->assertStatus(201)
            ->assertJson(['PedidoId' => $facturaData['PedidoId']]);

        $this->assertDatabaseHas('tblfacturas', ['PedidoId' => $facturaData['PedidoId']]);
    }

    public function test_store_factura_validation_error(): void
    {
        $response = $this->postJson('/api/facturas', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['PedidoId', 'monto_total', 'fecha_factura']);
    }

    public function test_show_factura(): void
    {
        $factura = TblFactura::factory()->create();

        $response = $this->getJson("/api/facturas/{$factura->FacturaId}");

        $response->assertStatus(200)
            ->assertJson(['PedidoId' => $factura->PedidoId]);
    }

    public function test_show_factura_not_found(): void
    {
        $response = $this->getJson('/api/facturas/999');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Factura no encontrada']);
    }

    public function test_update_factura(): void
    {
        $factura = TblFactura::factory()->create();
        $pedido = TblPedido::factory()->create();
        $updatedData = [
            'PedidoId' => $pedido->PedidoId,
            'monto_total' => 123.45,
            'fecha_factura' => '2024-02-20 10:00:00',
        ];

        $response = $this->putJson("/api/facturas/{$factura->FacturaId}", $updatedData);

        $response->assertStatus(200)
            ->assertJson(['PedidoId' => $updatedData['PedidoId']]);

        $this->assertDatabaseHas('tblfacturas', ['FacturaId' => $factura->FacturaId, 'PedidoId' => $updatedData['PedidoId']]);
    }

    public function test_update_factura_not_found(): void
    {
        $response = $this->putJson('/api/facturas/999', []);

        $response->assertStatus(404)
            ->assertJson(['message' => 'Factura no encontrada']);
    }

    public function test_destroy_factura(): void
    {
        $factura = TblFactura::factory()->create();

        $response = $this->deleteJson("/api/facturas/{$factura->FacturaId}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Factura eliminada']);

        $this->assertDatabaseMissing('tblfacturas', ['FacturaId' => $factura->FacturaId]);
    }

    public function test_destroy_factura_not_found(): void
    {
        $response = $this->deleteJson('/api/facturas/999');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Factura no encontrada']);
    }

    public function test_index_facturas_filter_by_pedido_id(): void
    {
        $pedido1 = TblPedido::factory()->create();
        $pedido2 = TblPedido::factory()->create();
        TblFactura::factory()->create(['PedidoId' => $pedido1->PedidoId]);
        TblFactura::factory()->create(['PedidoId' => $pedido2->PedidoId]);

        $response = $this->getJson("/api/facturas?PedidoId={$pedido1->PedidoId}");

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data.0.PedidoId', $pedido1->PedidoId)->etc()
            );
    }

    public function test_index_facturas_filter_by_fecha_factura(): void
    {
        $fecha1 = '2024-01-10 10:00:00';
        $fecha2 = '2024-01-11 12:00:00';
        TblFactura::factory()->create(['fecha_factura' => $fecha1]);
        TblFactura::factory()->create(['fecha_factura' => $fecha2]);

        $response = $this->getJson("/api/facturas?fecha_factura={$fecha1}");

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data.0.fecha_factura', $fecha1)->etc()
            );
    }

    public function test_index_facturas_pagination(): void
    {
        TblFactura::factory(15)->create();

        $response = $this->getJson('/api/facturas?per_page=5');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'total', 'per_page', 'current_page', 'last_page'])
            ->assertJson(['per_page' => 5]);
    }
}