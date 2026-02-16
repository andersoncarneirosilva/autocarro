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
        Schema::create('profissionais', function (Blueprint $table) {
    $table->id();
    $table->string('foto')->nullable();
    $table->string('nome');
    $table->string('documento')->nullable();
    $table->string('telefone');
    $table->string('especialidade');
    $table->string('email')->unique();
    $table->date('data_nascimento')->nullable();
    $table->string('genero')->nullable();
    $table->string('cor_agenda', 7)->default('#2F68B4');
    $table->boolean('status')->default(1);      // 1: Ativo, 0: Inativo
    $table->string('password');
    
    // COLUNAS JSON - A Mágica do Alcecar
    $table->json('servicos')->nullable(); // Ex: [{"nome": "Corte", "comissao": "50"}, {"nome": "Escova", "comissao": "30"}]
    $table->json('horarios')->nullable(); // Ex: {"segunda": {"inicio": "08:00", "fim": "18:00"}, ...}
    
    $table->timestamp('last_login_at')->nullable();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionarios');
    }
};
