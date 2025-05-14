<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TblClienteController;
use App\Http\Controllers\TblArticuloController;
use App\Http\Controllers\TblFacturaController;
use App\Http\Controllers\TblPedidoController;
use App\Http\Controllers\TblPY1Controller;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::apiResource('clientes', TblClienteController::class);
    Route::apiResource('articulos', TblArticuloController::class);
    Route::apiResource('facturas', TblFacturaController::class);
    Route::apiResource('pedidos', TblPedidoController::class);
    Route::apiResource('usuarios', TblPY1Controller::class);
});