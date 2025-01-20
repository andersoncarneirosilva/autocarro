<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterClientesTableAddUserId extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Adicionando a coluna user_id
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('veiculos', function (Blueprint $table) {
            // Removendo a coluna user_id se a migration for revertida
            $table->dropForeign(['user_id']); // Remove a chave estrangeira
            $table->dropColumn('user_id'); // Remove a coluna
        });
    }
};
