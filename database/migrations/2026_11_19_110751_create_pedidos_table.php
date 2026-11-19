<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('direccion_id')->constrained('direcciones')->restrictOnDelete();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('descuento_total', 10, 2)->default(0);
            $table->decimal('costo_envio', 10, 2)->default(0);
            $table->decimal('impuestos', 10, 2);
            $table->decimal('tasa_impuesto', 5, 2);
            $table->decimal('total', 10, 2);
            $table->enum('estado', ['pendiente', 'pagado', 'enviado', 'entregado', 'cancelado'])->default('pendiente');
            $table->string('numero_comprobante', 20)->nullable()->unique();
            $table->string('empresa_envio', 100)->nullable();
            $table->string('codigo_seguimiento', 100)->nullable();
            $table->timestamp('pagado_en')->nullable();
            $table->timestamp('enviado_en')->nullable();
            $table->timestamp('entregado_en')->nullable();
            $table->timestamp('cancelado_en')->nullable();
            $table->timestamp('comprobante_anulado_en')->nullable();
            $table->timestamps();

            $table->index('direccion_id');
            $table->index(['user_id', 'estado']);
            $table->index(['estado', 'created_at']);
        });

        DB::statement('ALTER TABLE pedidos ADD CONSTRAINT pedidos_montos_chk CHECK (subtotal >= 0 AND descuento_total >= 0 AND costo_envio >= 0 AND impuestos >= 0 AND tasa_impuesto >= 0 AND total >= 0)');
        DB::statement('ALTER TABLE pedidos ADD CONSTRAINT pedidos_total_formula_chk CHECK (total = subtotal - descuento_total + costo_envio)');
        DB::statement("ALTER TABLE pedidos ADD CONSTRAINT pedidos_envio_datos_chk CHECK (estado NOT IN ('enviado', 'entregado') OR (empresa_envio IS NOT NULL AND codigo_seguimiento IS NOT NULL))");
        DB::statement("ALTER TABLE pedidos ADD CONSTRAINT pedidos_comprobante_datos_chk CHECK (estado NOT IN ('pagado', 'enviado', 'entregado') OR numero_comprobante IS NOT NULL)");
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};