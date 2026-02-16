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
    Schema::create('empresas', function (Blueprint $table) {
        $table->id();
        $table->string('nome_responsavel');
        $table->string('razao_social')->nullable();
        $table->string('cnpj')->unique()->nullable();
        $table->string('slug')->unique();
        
        // Contato e Localização
        $table->string('email_corporativo')->unique();
        $table->string('telefone_comercial')->nullable();
        $table->string('whatsapp')->nullable();
        
        $table->string('cep')->nullable();
        $table->string('logradouro')->nullable();
        $table->string('numero')->nullable();
        $table->string('bairro')->nullable();
        $table->string('cidade')->nullable();
        $table->string('estado')->nullable();
        $table->string('complemento')->nullable();

        $table->string('logo')->nullable();
        
        // Configurações e Status
        $table->boolean('status')->default(true);
        $table->json('configuracoes')->nullable(); // Para cores do tema, horários, etc.
        
        $table->timestamps();
    });
}
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
