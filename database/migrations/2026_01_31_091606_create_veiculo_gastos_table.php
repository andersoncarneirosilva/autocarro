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
    Schema::create('veiculo_gastos', function (Blueprint $table) {
        $table->id();
        // Chave estrangeira para Multi-tenancy
        $table->unsignedBigInteger('empresa_id')->nullable()->index();
        
        $table->foreignId('veiculo_id')->constrained('veiculos')->onDelete('cascade');
        $table->string('descricao');
        $table->string('categoria')->nullable();
        $table->decimal('valor', 10, 2);
        $table->date('data_gasto');
        $table->string('fornecedor')->nullable();
        $table->string('codigo_infracao')->nullable();
        $table->boolean('pago')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('veiculo_gastos');
    }
};
