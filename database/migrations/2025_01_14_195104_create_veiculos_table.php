<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();

            $table->string('marca');
            $table->string('placa');
            $table->string('chassi');
            $table->string('cor');
            $table->string('ano');
            $table->string('renavam');
            $table->string('nome');
            $table->string('cpf');
            $table->string('cidade');
            $table->string('crv');
            $table->string('placaAnterior');
            $table->string('categoria');
            $table->string('motor');
            $table->string('combustivel');
            $table->string('infos');
            $table->string('arquivo_doc');

            $table->string('endereco');
            $table->string('arquivo_proc');
            $table->string('arquivo_proc_assinado')->nullable();
            $table->string('arquivo_atpve')->nullable();
            $table->string('arquivo_atpve_assinado')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('veiculos');
    }
};
