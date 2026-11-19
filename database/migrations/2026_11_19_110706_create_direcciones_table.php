<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('calle', 200);
            $table->string('ciudad', 100);
            $table->string('referencia', 255)->nullable();
            $table->string('codigo_postal', 20)->nullable();
            $table->boolean('es_principal')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->index('user_id');
        });

        DB::statement('CREATE UNIQUE INDEX direcciones_principal_uq ON direcciones (user_id) WHERE es_principal IS TRUE AND deleted_at IS NULL');
    }

    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};