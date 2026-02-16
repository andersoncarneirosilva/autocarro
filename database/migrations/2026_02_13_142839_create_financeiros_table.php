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
    Schema::create('financeiros', function (Blueprint $table) {
        $table->id();
        $table->foreignId('empresa_id')->constrained()->onDelete('cascade');
        
        // Relacionamentos opcionais (para serviços ou despesas avulsas)
        $table->foreignId('agendamento_id')->nullable()->constrained('agendas')->onDelete('set null');
        $table->foreignId('profissional_id')->nullable()->constrained('profissionais')->onDelete('set null');
        
        $table->string('descricao');
        $table->decimal('valor', 10, 2);
        $table->decimal('comissao_valor', 10, 2)->default(0);
        $table->enum('tipo', ['receita', 'despesa'])->default('receita');
        $table->string('forma_pagamento')->nullable();
        $table->date('data_pagamento');
        $table->text('observacoes')->nullable();
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financeiros');
    }
};
