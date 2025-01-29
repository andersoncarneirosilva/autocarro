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
            if (!Schema::hasColumn('outorgados', 'email_outorgado')) {
                $table->string('email_outorgado', 255)->after('end_outorgado')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('outorgados', function (Blueprint $table) {
            if (Schema::hasColumn('outorgados', 'email_outorgado')) {
                $table->dropColumn('email_outorgado');
            }
        });
    }
};
