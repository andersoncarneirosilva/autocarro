<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('multas', function (Blueprint $col) {
            $col->id();
            $col->foreignId('veiculo_id')->constrained('veiculos')->onDelete('cascade');
            $col->string('codigo_infracao')->nullable();
            $col->string('descricao');
            $col->decimal('valor', 10, 2);
            $col->date('data_infracao');
            $col->date('data_vencimento')->nullable();
            $col->enum('status', ['pendente', 'pago', 'recurso'])->default('pendente');
            $col->string('orgao_emissor')->nullable();
            $col->text('observacoes')->nullable();
            $col->timestamps();
        });
    }

    public function down() { Schema::dropIfExists('multas'); }
};
