<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblpedidos', function (Blueprint $table) {
            $table->id('PedidoId');
            $table->unsignedBigInteger('ClienteId'); 
            $table->dateTime('fecha_pedido');
            $table->timestamps();

            $table->foreign('ClienteId')->references('ClienteId')->on('tblclientes');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblpedidos');
    }
};