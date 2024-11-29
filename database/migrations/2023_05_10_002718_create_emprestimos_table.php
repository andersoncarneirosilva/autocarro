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
        Schema::create('emprestimos', function (Blueprint $table) {
            $table->id();
            $table->string('colaborador');
            $table->string('motivo');
            $table->string('email');
            $table->string('qt_parcela');
            $table->string('parcela');
            $table->string('total');
            $table->string('class_status');
            $table->string('status');
            $table->timestamp('data_vencimento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprestimos');
    }
};
