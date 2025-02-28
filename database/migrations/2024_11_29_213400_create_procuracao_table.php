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
        Schema::create('procuracaos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('endereco');
            $table->string('cpf');
            $table->string('marca');
            $table->string('placa');
            $table->string('chassi');
            $table->string('cor');
            $table->string('ano');
            $table->string('renavam');
            $table->string('arquivo_doc');
            $table->string('arquivo_proc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_doc_veiculo');
    }
};
