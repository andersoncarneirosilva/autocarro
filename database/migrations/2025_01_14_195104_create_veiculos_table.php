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

        // OBRIGATORIAS (Identificação)
        $table->string('marca')->nullable();
        $table->string('modelo')->nullable();
        $table->string('versao')->nullable();
        $table->string('placa', 10)->nullable(); // Definido tamanho sugerido
        $table->string('chassi')->nullable();
        $table->string('cor');
        $table->integer('ano_fabricacao');
        $table->integer('ano_modelo');
        $table->string('renavam')->nullable();
        $table->string('nome')->nullable(); // Nome do proprietário atual/anterior?
        $table->string('cpf')->nullable();
        $table->string('cidade')->nullable();
        $table->string('crv')->nullable();
        $table->string('placaAnterior')->nullable();
        $table->string('categoria')->nullable();
        $table->string('motor')->nullable();
        $table->string('combustivel')->nullable();
        $table->string('infos')->nullable();
        $table->string('tipo')->nullable();

        // FINANCEIRO / COMERCIAL
        $table->string('cambio')->nullable();
        $table->string('portas')->nullable();
        $table->string('estado')->nullable();
        $table->string('especiais')->nullable();
        $table->decimal('valor', 15, 2)->nullable();
        $table->decimal('valor_oferta', 15, 2)->nullable();
        $table->decimal('entrada', 15, 2)->nullable();
        $table->integer('qtd_parcelas')->nullable()->default(1);
        $table->decimal('taxa_juros', 5, 2)->nullable()->default(0);
        $table->decimal('valor_parcela', 15, 2)->nullable();
        $table->boolean('exibir_parcelamento')->default(false);
        $table->integer('kilometragem')->nullable(); // Alterado para integer
        $table->text('observacoes')->nullable();
        
        // CAMPOS JSON (Ótimo para flexibilidade!)
        $table->json('adicionais')->nullable();
        $table->json('opcionais')->nullable();
        $table->json('modificacoes')->nullable();
        $table->text('descricao')->nullable();
        $table->json('images')->nullable();
        
        // DOCUMENTOS E STATUS
        $table->string('status')->default('Disponível'); // Valor padrão
        $table->string('arquivo_doc')->nullable();
        $table->unsignedBigInteger('size_doc')->nullable();

        // INTEGRAÇÃO FIPE
        $table->string('fipe_marca_id')->nullable();
        $table->string('fipe_modelo_id')->nullable();
        $table->string('fipe_versao_id')->nullable();

        $table->foreignId('cliente_id')->nullable()->constrained('clientes')->onDelete('set null')->after('user_id');
        $table->decimal('valor_venda', 15, 2)->nullable();
        $table->date('data_venda')->nullable();
        // RELACIONAMENTOS
        // Vendedor (Usuário do sistema)
        $table->foreignId('vendedor_id')->nullable()->constrained('users')->onDelete('set null');
        $table->foreignId('empresa_id')->nullable()->constrained('users')->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('veiculos');
    }
};
