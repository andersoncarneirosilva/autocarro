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
            // Alterando de JSON para TEXT
            $table->text('descricao')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('anuncios', function (Blueprint $table) {
            // Revertendo para JSON caso necessário
            $table->json('descricao')->nullable()->change();
        });
    }
};
