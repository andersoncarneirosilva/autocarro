<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
    Schema::table('veiculos', function (Blueprint $table) {
        $table->string('fipe_marca_id')->nullable();
        $table->string('fipe_modelo_id')->nullable();
        $table->string('fipe_versao_id')->nullable(); // Ex: 2011-1
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('veiculos', function (Blueprint $table) {
            //
        });
    }
};
