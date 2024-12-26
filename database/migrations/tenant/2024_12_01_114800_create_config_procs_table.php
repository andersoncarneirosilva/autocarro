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
        Schema::create('config_procs', function (Blueprint $table) {
            $table->id();
            $table->string('nome_outorgado');
            $table->string('cpf_outorgado');
            $table->string('end_outorgado');
            $table->string('nome_testemunha');
            $table->string('cpf_testemunha');
            $table->string('end_testemunha');
            $table->text('texto_poderes');
            $table->text('texto_final');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configprocs');
    }
};
