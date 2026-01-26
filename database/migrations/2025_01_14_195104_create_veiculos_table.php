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

            // OBRIGATORIAS
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('versao')->nullable();
            $table->string('placa')->nullable();
            $table->string('chassi')->nullable();
            $table->string('cor');
            $table->string('ano');
            $table->string('renavam')->nullable();
            $table->string('nome')->nullable();
            $table->string('cpf')->nullable();
            $table->string('cidade')->nullable();
            $table->string('crv')->nullable();
            $table->string('placaAnterior')->nullable();
            $table->string('categoria')->nullable();
            $table->string('motor')->nullable();
            $table->string('combustivel')->nullable();
            $table->string('infos')->nullable();
            $table->string('tipo')->nullable();

            //  OPCIONAIS
            $table->string('cambio')->nullable();
            $table->string('portas')->nullable();
            $table->string('estado')->nullable();
            $table->string('especiais')->nullable();
            $table->decimal('valor', 15, 2)->nullable();
            $table->decimal('valor_oferta', 15, 2)->nullable();
            $table->integer('qtd_parcelas')->nullable()->default(1);
            $table->decimal('taxa_juros', 5, 2)->nullable()->default(0);
            $table->decimal('valor_parcela', 15, 2)->nullable();
            $table->boolean('exibir_parcelamento')->default(false);
            $table->string('kilometragem')->nullable();
            $table->text('observacoes')->nullable();
            $table->json('adicionais')->nullable();
            $table->json('opcionais')->nullable();
            $table->json('modificacoes')->nullable();
            $table->json('descricao')->nullable();
            $table->json('images')->nullable();
            $table->string('status')->nullable();
            $table->string('arquivo_doc')->nullable();
            $table->unsignedBigInteger('size_doc')->nullable();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('veiculos');
    }
};
