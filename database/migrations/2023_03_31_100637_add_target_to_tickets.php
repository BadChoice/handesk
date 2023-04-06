<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTargetToTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('target')->nullable()->after('title');
            $table->string('position')->nullable()->after('target');
            $table->string('mob_number')->nullable()->after('position');
            $table->string('affiliation')->nullable()->after('mob_number');
            $table->text('location')->nullable()->after('affiliation');
            $table->text('description')->nullable()->after('location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            //
        });
    }
}
