<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblclientes', function (Blueprint $table) {
            $table->id('ClienteId'); 
            $table->string('nombre');
            $table->string('telefono');
            $table->string('tipo_cliente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblclientes');
    }
};