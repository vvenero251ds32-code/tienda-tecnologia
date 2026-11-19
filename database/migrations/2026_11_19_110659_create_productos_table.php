<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias')->restrictOnDelete();
            $table->foreignId('marca_id')->constrained('marcas')->restrictOnDelete();
            $table->string('sku', 50)->unique();
            $table->string('nombre', 200);
            $table->string('modelo', 100)->nullable();
            $table->text('descripcion')->nullable();
            $table->jsonb('especificaciones')->nullable();
            $table->decimal('precio_regular', 10, 2);
            $table->decimal('precio_oferta', 10, 2)->nullable();
            $table->timestamp('inicio_oferta')->nullable();
            $table->timestamp('fin_oferta')->nullable();
            $table->integer('stock')->default(0);
            $table->smallInteger('meses_garantia')->default(0);
            $table->string('imagen_path', 255)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->index('categoria_id');
            $table->index('marca_id');
            $table->index('activo');
            $table->index('precio_regular');
        });

        DB::statement('ALTER TABLE productos ADD CONSTRAINT productos_stock_chk CHECK (stock >= 0)');
        DB::statement('ALTER TABLE productos ADD CONSTRAINT productos_garantia_chk CHECK (meses_garantia >= 0)');
        DB::statement('ALTER TABLE productos ADD CONSTRAINT productos_precio_regular_chk CHECK (precio_regular >= 0)');
        DB::statement('ALTER TABLE productos ADD CONSTRAINT productos_precio_oferta_chk CHECK (precio_oferta IS NULL OR (precio_oferta >= 0 AND precio_oferta < precio_regular))');
        DB::statement('ALTER TABLE productos ADD CONSTRAINT productos_vigencia_oferta_chk CHECK ((precio_oferta IS NULL) = (fin_oferta IS NULL))');
        DB::statement('ALTER TABLE productos ADD CONSTRAINT productos_fechas_oferta_chk CHECK (inicio_oferta IS NULL OR fin_oferta IS NULL OR inicio_oferta < fin_oferta)');
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};