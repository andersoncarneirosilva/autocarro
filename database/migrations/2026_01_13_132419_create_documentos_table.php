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
    Schema::create('documentos', function (Blueprint $table) {
        $table->id();
        
        // Relacionamentos (Foreign Keys)
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
        $table->foreignId('anuncio_id')->constrained('anuncios')->onDelete('cascade');
        // Campos específicos solicitados
        $table->string('arquivo_proc'); // NO NULL conforme seu esquema
        $table->bigInteger('size_proc')->unsigned()->nullable();
        $table->string('arquivo_proc_assinado')->nullable();
        
        $table->string('arquivo_atpve')->nullable();
        $table->bigInteger('size_atpve')->unsigned()->nullable();
        $table->string('arquivo_atpve_assinado')->nullable();
        
        // Campos de tamanho do PDF gerado
        $table->string('size_proc_pdf')->nullable();
        $table->string('size_atpve_pdf')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
