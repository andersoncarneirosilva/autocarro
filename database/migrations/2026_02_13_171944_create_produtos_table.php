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
    Schema::create('produtos', function (Blueprint $table) {
        $table->id();
        // Certifique-se de que esta linha existe:
        $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
        
        $table->string('nome');
        $table->string('codigo_barras')->nullable();
        $table->string('marca')->nullable();
        $table->decimal('preco_custo', 10, 2)->default(0);
        $table->decimal('preco_venda', 10, 2)->default(0);
        $table->integer('estoque_atual')->default(0);
        $table->integer('estoque_minimo')->default(5);
        $table->string('categoria')->default('Cabelo');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
