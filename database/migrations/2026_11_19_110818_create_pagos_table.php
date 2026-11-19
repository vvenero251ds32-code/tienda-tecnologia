<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->restrictOnDelete();
            $table->foreignId('confirmado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('metodo', ['pasarela_simulada', 'transferencia']);
            $table->decimal('monto', 10, 2);
            $table->enum('estado', ['pendiente', 'confirmado', 'rechazado'])->default('pendiente');
            $table->string('referencia', 100)->nullable();
            $table->timestamp('pagado_en')->nullable();
            $table->timestamps();

            $table->index('pedido_id');
            $table->index('confirmado_por');
        });

        DB::statement('ALTER TABLE pagos ADD CONSTRAINT pagos_monto_chk CHECK (monto > 0)');
        DB::statement("CREATE UNIQUE INDEX pagos_confirmado_unico_uq ON pagos (pedido_id) WHERE estado = 'confirmado'");
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};