<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIsApiProductBacklogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('product_backlogs', function (Blueprint $table) {
            $table->boolean('is_api')->nullable()->after('position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('product_backlogs', function (Blueprint $table) {
            $table->dropColumn('is_api');
        });
    }
}
