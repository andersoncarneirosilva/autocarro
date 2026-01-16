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
        Schema::create('anuncios', function (Blueprint $table) {
            $table->id();

            // OBRIGATORIAS
            $table->string('marca_real')->nullable();
            $table->string('modelo_real')->nullable();
            $table->string('marca');
            $table->string('placa');
            $table->string('chassi');
            $table->string('cor');
            $table->string('ano');
            $table->string('renavam');
            $table->string('nome');
            $table->string('cpf');
            $table->string('cidade');
            $table->string('crv');
            $table->string('placaAnterior');
            $table->string('categoria');
            $table->string('motor');
            $table->string('combustivel');
            $table->string('infos');
            $table->string('tipo');

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
            $table->string('status_anuncio')->nullable();
            $table->string('arquivo_doc')->nullable();
            $table->unsignedBigInteger('size_doc')->nullable();

            $table->string('slug')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anuncios');
    }
};
