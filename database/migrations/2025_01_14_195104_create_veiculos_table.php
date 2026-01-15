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
            $table->decimal('valor', 15, 2)->nullable();
            $table->decimal('valor_oferta', 15, 2)->nullable();
            
            $table->string('kilometragem')->nullable();
            $table->text('observacoes')->nullable();
            $table->json('adicionais')->nullable();
            $table->json('opcionais')->nullable();
            $table->json('modificacoes')->nullable();
            $table->json('descricao')->nullable();

            $table->json('images')->nullable();
            $table->string('status')->nullable();

            
            $table->string('endereco')->nullable();
            
            $table->string('arquivo_doc')->nullable();
            $table->string('arquivo_proc')->nullable();
            $table->string('arquivo_proc_assinado')->nullable();
            $table->string('arquivo_atpve')->nullable();
            $table->string('arquivo_atpve_assinado')->nullable();

            $table->string('size_proc_pdf')->nullable();
            $table->string('size_atpve_pdf')->nullable();

            $table->unsignedBigInteger('size_doc')->nullable();
            $table->unsignedBigInteger('size_proc')->nullable();
            $table->unsignedBigInteger('size_atpve')->nullable();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('veiculos');
    }
};
