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
            if (! Schema::hasColumn('veiculos', 'status')) {
                $table->string('status')->nullable()->after('image');
            }
        });
    }

    public function down()
    {
        Schema::table('veiculos', function (Blueprint $table) {
            if (Schema::hasColumn('veiculos', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
