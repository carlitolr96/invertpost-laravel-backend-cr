<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblarticulos', function (Blueprint $table) {
            $table->id('ArticuloId'); // Clave Primaria Autoincremental [cite: 58]
            $table->string('descripcion');
            $table->string('fabricante');
            $table->string('codigo_barras')->unique();
            $table->decimal('precio', 10, 2); // Ajustar precisión según necesidad
            $table->integer('stock');
            $table->timestamps(); // created_at y updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblarticulos');
    }
};
