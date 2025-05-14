<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TblClienteController;
use App\Http\Controllers\TblArticuloController;
use App\Http\Controllers\TblPedidoController;
use App\Http\Controllers\TblFacturaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TblPY1Controller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (auth()->check()) {
        return view('/components/hero');
    }
    return redirect()->route('login');
});

// Rutas de Autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Vista web
    Route::get('/components/clientes', [TblClienteController::class, 'index'])->name('components.clientes');
    Route::get('/components/articulos', [TblArticuloController::class, 'index'])->name('components.articulos');
    Route::get('/components/pedidos', [TblPedidoController::class, 'index'])->name('components.pedidos');
    Route::get('/components/facturas', [TblFacturaController::class, 'index'])->name('components.facturas');
    
    // Rutas para edición de recursos web (formularios)
    Route::get('/clientes/{cliente}/edit', [TblClienteController::class, 'edit'])->name('clientes.edit');
    Route::get('/articulos/{articulo}/edit', [TblArticuloController::class, 'edit'])->name('articulo.edit');
    Route::get('/facturas/{factura}/edit', [TblFacturaController::class, 'edit'])->name('factura.edit');
    Route::get('/pedidos/{pedido}/edit', [TblPedidoController::class, 'edit'])->name('pedido.edit');
    
    Route::post('/clientes', [TblClienteController::class, 'store'])->name('clientes.store');
    Route::post('/usuarios', [TblPY1Controller::class, 'store'])->name('usuarios.store');

    Route::resource('clientes', TblClienteController::class);
});