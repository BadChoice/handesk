<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeTrackerLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_tracker_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->engine = "MyISAM";
            $table->integer('time_tracker_id')->unsigned()->index();
            $table->foreign('time_tracker_id')->references('id')->on('time_trackers')->onDelete('cascade');
            $table->integer('start')->default(0);
            $table->integer('duration')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_tracker_logs');
    }
}
