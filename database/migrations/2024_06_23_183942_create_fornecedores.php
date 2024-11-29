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
        Schema::create('fornecedors', function (Blueprint $table) {
            $table->id();
            $table->string('razao_social');
            $table->string('nome_fantasia');
            $table->string('cnpj');
            $table->string('representante');
            $table->string('telefone');
            $table->string('ipi');
            $table->string('icms');
            $table->string('margem');
            $table->string('marcador');
            $table->string('valor_pedido_minimo');
            $table->string('prazo_faturamento');
            $table->string('tipo_frete');
            $table->string('transportadora');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fornecedor');
    }
};
