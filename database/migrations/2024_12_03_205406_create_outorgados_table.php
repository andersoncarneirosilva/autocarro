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
        Schema::create('outorgados', function (Blueprint $table) {
            $table->id();
            $table->string('nome_outorgado');
            $table->string('cpf_outorgado');
            $table->string('rg_outorgado');
            $table->string('end_outorgado');
            $table->string('telefone_outorgado');
            $table->string('email_outorgado', 255);

            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Chave estrangeira para o usuário
            $table->foreignId('empresa_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outorgados');
    }
};
