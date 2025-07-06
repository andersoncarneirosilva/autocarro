<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('fornecedores', function (Blueprint $table) {
        $table->id();
        $table->string('razao_social');
        $table->string('nome_fantasia')->nullable();
        $table->string('cnpj', 14)->unique();
        $table->string('email')->nullable();
        $table->string('telefone')->nullable();
        $table->string('logradouro')->nullable();
        $table->string('numero')->nullable();
        $table->string('bairro')->nullable();
        $table->string('cidade')->nullable();
        $table->string('estado', 2)->nullable();
        $table->string('cep', 9)->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fornecedors');
    }
};
