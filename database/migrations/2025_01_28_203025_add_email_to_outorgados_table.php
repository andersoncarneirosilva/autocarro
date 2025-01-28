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
    Schema::table('outorgados', function (Blueprint $table) {
        $table->string('email_outorgado')->unique()->after('end_outorgado'); // Adiciona o campo 'email'
    });
}

public function down()
{
    Schema::table('outorgados', function (Blueprint $table) {
        $table->dropColumn('email_outorgado'); // Remove o campo 'email' em caso de rollback
    });
}
};
