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
    Schema::create('infracoes', function (Blueprint $table) {
        $table->id();
        $table->string('codigo')->unique(); // Ex: 605-1
        $table->text('descricao');       // Ex: Avançar o sinal vermelho
        $table->string('gravidade');       // Ex: Gravíssima
        $table->integer('pontos');         // Ex: 7
        $table->decimal('valor', 10, 2);   // Ex: 293.47
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infracaos');
    }
};
