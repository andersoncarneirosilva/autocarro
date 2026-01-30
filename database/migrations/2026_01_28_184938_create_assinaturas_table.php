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
        Schema::create('assinaturas', function (Blueprint $table) {
            $table->id();
            $table->string('plano');
            $table->decimal('valor', 10, 2);
            $table->string('class_status')->default('badge badge-outline-warning');
            $table->string('status')->default('pending');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->string('external_reference')->nullable();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assinaturas');
    }
};