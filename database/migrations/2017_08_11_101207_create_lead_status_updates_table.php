<?php

use App\Lead;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadStatusUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_status_updates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('new_status')->default(Lead::STATUS_NEW);
            $table->text('body')->nullable();
            $table->unsignedInteger('lead_id')->unsigned();
            $table->unsignedInteger('user_id')->unsigned();
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
        Schema::dropIfExists('lead_status_updates');
    }
}
