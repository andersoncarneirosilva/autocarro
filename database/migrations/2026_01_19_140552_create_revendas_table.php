<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('revendas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('CPNJ');
            $table->json('fones');
            $table->string('rua');
            $table->string('numero', 20);
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado', 2);
            $table->string('cep', 10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('revendas');
    }
};
