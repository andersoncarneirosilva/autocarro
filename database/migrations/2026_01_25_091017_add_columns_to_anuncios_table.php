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
        Schema::table('anuncios', function (Blueprint $table) {
            // Adiciona as colunas após 'descricao'
            $table->string('modelo_carro')->nullable()->after('descricao');
            $table->unsignedBigInteger('visitas')->default(0)->after('modelo_carro');
        });
    }

    public function down(): void
    {
        Schema::table('anuncios', function (Blueprint $table) {
            $table->dropColumn(['modelo_carro', 'visitas']);
        });
    }
};
