<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblpy1s', function (Blueprint $table) {
            $table->id('UserId'); // Clave Primaria Autoincremental [cite: 60]
            $table->string('usuario')->unique();
            $table->string('password');
            $table->string('cedula')->unique();
            $table->string('telefono');
            $table->string('tipo_sangre');
            $table->timestamps(); // created_at y updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblpy1s');
    }
};