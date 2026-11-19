<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carrito_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrito_id')->constrained('carritos')->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->integer('cantidad');

            $table->unique(['carrito_id', 'producto_id']);
            $table->index('producto_id');
        });

        DB::statement('ALTER TABLE carrito_detalles ADD CONSTRAINT carrito_detalles_cantidad_chk CHECK (cantidad > 0)');
    }

    public function down(): void
    {
        Schema::dropIfExists('carrito_detalles');
    }
};