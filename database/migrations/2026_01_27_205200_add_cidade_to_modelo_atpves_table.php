<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('modelo_atpves', function (Blueprint $table) {
            // Adicionando a coluna cidade após a coluna user_id (ou outra de sua preferência)
            $table->string('cidade')->nullable()->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('modelo_atpves', function (Blueprint $table) {
            $table->dropColumn('cidade');
        });
    }
};