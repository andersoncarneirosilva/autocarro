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
        Schema::table('users', function (Blueprint $table) {
            // Adicionando as colunas após o campo 'telefone' ou onde preferir
            $table->string('cidade')->nullable()->after('telefone');
            $table->string('estado', 2)->nullable()->after('cidade'); 
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cidade', 'estado']);
        });
    }
};
