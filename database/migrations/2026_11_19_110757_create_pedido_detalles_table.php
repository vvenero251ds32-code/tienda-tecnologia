<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedido_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained('productos')->restrictOnDelete();
            $table->string('sku_producto', 50);
            $table->string('nombre_producto', 200);
            $table->integer('cantidad');
            $table->decimal('precio_regular_unitario', 10, 2);
            $table->decimal('precio_unitario_aplicado', 10, 2);
            $table->smallInteger('meses_garantia_aplicados')->default(0);
            $table->decimal('subtotal_linea', 10, 2);

            $table->unique(['pedido_id', 'producto_id']);
            $table->index('producto_id');
        });

        DB::statement('ALTER TABLE pedido_detalles ADD CONSTRAINT pedido_detalles_cantidad_chk CHECK (cantidad > 0)');
        DB::statement('ALTER TABLE pedido_detalles ADD CONSTRAINT pedido_detalles_precios_chk CHECK (precio_regular_unitario >= 0 AND precio_unitario_aplicado >= 0 AND meses_garantia_aplicados >= 0)');
        DB::statement('ALTER TABLE pedido_detalles ADD CONSTRAINT pedido_detalles_subtotal_chk CHECK (subtotal_linea = cantidad * precio_unitario_aplicado)');
    }

    public function down(): void
    {
        Schema::dropIfExists('pedido_detalles');
    }
};