<?php

namespace Tests\Unit\app\Http\Controllers;

use App\Models\TblPY1;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TblPY1ControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index_users(): void
    {
        TblPY1::factory(3)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['UserId', 'usuario', 'cedula', 'telefono', 'tipo_sangre']
                ],
                'total',
                'per_page',
                'current_page',
                'last_page',
            ]);
    }

    public function test_store_user(): void
    {
        $userData = [
            'usuario' => $this->faker->userName,
            'password' => 'password123',
            'cedula' => '123456789',
            'telefono' => '123-456-7890',
            'tipo_sangre' => 'O+',
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201)
            ->assertJson(['usuario' => $userData['usuario']]);

        $this->assertDatabaseHas('tblpy1s', ['usuario' => $userData['usuario']]);
    }

    public function test_store_user_validation_error(): void
    {
        $response = $this->postJson('/api/users', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['usuario', 'password', 'cedula', 'telefono', 'tipo_sangre']);
    }

    public function test_show_user(): void
    {
        $user = TblPY1::factory()->create();

        $response = $this->getJson("/api/users/{$user->UserId}");

        $response->assertStatus(200)
            ->assertJson(['usuario' => $user->usuario]);
    }

    public function test_show_user_not_found(): void
    {
        $response = $this->getJson('/api/users/999');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Usuario no encontrado']);
    }

    public function test_update_user(): void
    {
        $user = TblPY1::factory()->create();
        $updatedData = [
            'usuario' => 'newuser',
            'telefono' => '987-654-3210',
        ];

        $response = $this->putJson("/api/users/{$user->UserId}", $updatedData);

        $response->assertStatus(200)
            ->assertJson(['usuario' => $updatedData['usuario']]);

        $this->assertDatabaseHas('tblpy1s', ['UserId' => $user->UserId, 'usuario' => $updatedData['usuario']]);
    }

    public function test_update_user_not_found(): void
    {
        $response = $this->putJson('/api/users/999', []);

        $response->assertStatus(404)
            ->assertJson(['message' => 'Usuario no encontrado']);
    }

    public function test_destroy_user(): void
    {
        $user = TblPY1::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->UserId}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Usuario eliminado']);

        $this->assertDatabaseMissing('tblpy1s', ['UserId' => $user->UserId]);
    }

    public function test_destroy_user_not_found(): void
    {
        $response = $this->deleteJson('/api/users/999');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Usuario no encontrado']);
    }

    public function test_index_users_filter_by_usuario(): void
    {
        TblPY1::factory()->create(['usuario' => 'testuser1']);
        TblPY1::factory()->create(['usuario' => 'testuser2']);

        $response = $this->getJson('/api/users?usuario=testuser1');

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data.0.usuario', 'testuser1')->etc()
            );
    }

    public function test_index_users_filter_by_cedula(): void
    {
        TblPY1::factory()->create(['cedula' => '123456789']);
        TblPY1::factory()->create(['cedula' => '987654321']);

        $response = $this->getJson('/api/users?cedula=123456789');

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data.0.cedula', '123456789')->etc()
            );
    }

    public function test_index_users_pagination(): void
    {
        TblPY1::factory(15)->create();

        $response = $this->getJson('/api/users?per_page=5');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'total', 'per_page', 'current_page', 'last_page'])
            ->assertJson(['per_page' => 5]);
    }
}