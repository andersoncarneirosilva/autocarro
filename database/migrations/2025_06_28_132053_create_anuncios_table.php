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
        Schema::create('anuncios', function (Blueprint $table) {
            $table->id();
            $table->string('marca');
            $table->string('modelo')->nullable();
            $table->string('ano')->nullable();
            $table->string('kilometragem')->nullable();
            $table->string('cor')->nullable();
            $table->string('cambio')->nullable();
            $table->string('portas')->nullable();
            $table->string('combustivel')->nullable();
            $table->string('valor')->nullable();
            $table->string('status')->nullable();
            $table->json('images')->nullable();

            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anuncios');
    }
};
