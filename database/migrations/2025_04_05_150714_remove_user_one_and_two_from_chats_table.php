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
        Schema::table('chats', function (Blueprint $table) {
            // Remove as foreign keys antes de remover as colunas
            $table->dropForeign(['user_one']);
            $table->dropForeign(['user_two']);

            // Agora pode remover as colunas
            $table->dropColumn(['user_one', 'user_two']);
        });
    }

    public function down()
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->unsignedBigInteger('user_one');
            $table->unsignedBigInteger('user_two');

            $table->foreign('user_one')->references('id')->on('users');
            $table->foreign('user_two')->references('id')->on('users');
        });
    }

};
