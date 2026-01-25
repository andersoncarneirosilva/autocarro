<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabela de Marcas (Audi, BMW, Fiat...)
        Schema::create('marcas', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Tabela de Modelos (A3, A4, Q3...)
        Schema::create('modelos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marca_id')->constrained('marcas')->onDelete('cascade');
            $table->string('nome');
            $table->string('slug');
            $table->timestamps();
        });

        // Tabela de Versões (1.4 TFSI, 2.0 Ambition...)
        Schema::create('versoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modelo_id')->constrained('modelos')->onDelete('cascade');
            $table->string('nome');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('versoes');
        Schema::dropIfExists('modelos');
        Schema::dropIfExists('marcas');
    }
};