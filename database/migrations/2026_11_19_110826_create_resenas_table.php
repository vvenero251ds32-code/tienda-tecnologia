<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resenas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->smallInteger('calificacion');
            $table->text('comentario')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'producto_id']);
            $table->index('producto_id');
        });

        DB::statement('ALTER TABLE resenas ADD CONSTRAINT resenas_calificacion_chk CHECK (calificacion BETWEEN 1 AND 5)');
    }

    public function down(): void
    {
        Schema::dropIfExists('resenas');
    }
};