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
    Schema::create('whatsapp_instances', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('empresa_id'); // Referência ao tenant
        $table->string('name')->unique(); 
        $table->string('token')->nullable();
        $table->string('status')->default('disconnected');
        $table->text('qrcode')->nullable();
        $table->timestamps();

        // Relacionamento (ajuste o nome da tabela de empresas se necessário)
        $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_instances');
    }
};
