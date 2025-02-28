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
    Schema::table('veiculos', function (Blueprint $table) {
        $table->unsignedBigInteger('size_doc')->nullable()->after('arquivo_doc');
        $table->unsignedBigInteger('size_proc')->nullable()->after('arquivo_proc');
        $table->unsignedBigInteger('size_atpve')->nullable()->after('arquivo_atpve');
    });
}

public function down()
{
    Schema::table('veiculos', function (Blueprint $table) {
        $table->dropColumn(['size_proc', 'size_atpve']);
    });
}

};
