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
        Schema::create('adiantamentos', function (Blueprint $table) {
            $table->id();
            $table->string('colaborador');
            $table->string('email');
            $table->string('arquivo');
            $table->string('mes');
            $table->string('numeromes');
            $table->string('status');
            $table->string('class_status');
            $table->string('foto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adiantamentos');
    }
};
