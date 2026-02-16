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
    Schema::create('servicos', function (Blueprint $table) {
    $table->id();
    $table->string('nome');
    $table->decimal('preco', 10, 2)->default(0);
    $table->integer('duracao')->nullable(); // Duração em minutos
    $table->text('descricao')->nullable();
    $table->string('image')->nullable();
    
    // CORREÇÃO: Vincula à tabela 'empresas'
    // Agora o empresa_id 5 será buscado na tabela empresas (onde ele existe)
    $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
    
    $table->timestamps();
    $table->softDeletes(); 
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicos');
    }
};
