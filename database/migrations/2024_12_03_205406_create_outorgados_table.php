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
            $table->string('end_outorgado');
            
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Chave estrangeira para o usuário

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
