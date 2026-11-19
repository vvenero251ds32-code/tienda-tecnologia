<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('rol', ['admin', 'cliente'])->default('cliente')->after('password');
            $table->string('documento_identidad', 20)->nullable()->unique()->after('rol');
            $table->string('telefono', 20)->nullable()->after('documento_identidad');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['rol', 'documento_identidad', 'telefono']);
        });
    }
};