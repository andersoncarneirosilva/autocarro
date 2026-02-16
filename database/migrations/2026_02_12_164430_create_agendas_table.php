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
    Schema::create('agendas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('empresa_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('profissional_id')->constrained('profissionais')->onDelete('cascade');
        
        $table->string('cliente_nome');
        $table->string('cliente_telefone')->nullable();
        
        // Armazenará o snapshot dos serviços: [{id:1, nome:'Lavagem', preco:50}, ...]
        $table->json('servicos_json'); 
        
        $table->dateTime('data_hora_inicio');
        $table->dateTime('data_hora_fim');
        
        $table->text('pedido_especial')->nullable();
        $table->decimal('valor_total', 10, 2);
        $table->string('status')->default('pendente');
        $table->timestamp('lembrete_enviado_em')->nullable();
        $table->timestamps();
        $table->softDeletes(); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
