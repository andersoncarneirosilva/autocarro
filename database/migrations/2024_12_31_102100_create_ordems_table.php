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
        Schema::create('ordems', function (Blueprint $table) {
            $table->id(); // ID único para a tabela
            $table->foreignId('cliente_id')->constrained()->cascadeOnDelete(); // Relacionamento com a tabela de clientes
            $table->foreignId('documento_id')->constrained()->cascadeOnDelete(); // Relacionamento com a tabela de clientes
            // $table->string('veiculo_id'); // Serviço resumido
            $table->json('tipo_servico'); // Serviço resumido
            $table->text('descricao');
            $table->decimal('valor_servico', 10, 2);
            $table->decimal('taxa_administrativa', 10, 2);
            $table->decimal('valor_total', 10, 2);
            $table->string('forma_pagamento');
            $table->text('classe_status');
            $table->text('status'); // Descrição detalhada do serviço
            $table->timestamps(); // Timestamps padrão para created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordems');
    }
};
