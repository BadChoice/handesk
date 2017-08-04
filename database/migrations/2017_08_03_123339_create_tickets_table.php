<?php

use App\Ticket;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string("title");
            $table->text('body');
            $table->unsignedInteger('requester_id');
            $table->unsignedInteger("team_id")->nullable();
            $table->unsignedInteger("user_id")->nullable();
            $table->tinyInteger("status")->default(Ticket::STATUS_NEW);
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
        Schema::dropIfExists('tickets');
    }
}
