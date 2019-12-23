<?php

use App\Ticket;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('title');
            $table->text('body');
            $table->string('public_token', 24)->unique();
            $table->unsignedInteger('requester_id');
            $table->unsignedInteger('team_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->tinyInteger('status')->default(Ticket::STATUS_NEW);
            $table->tinyInteger('priority')->default(Ticket::PRIORITY_NORMAL);
            $table->tinyInteger('level')->default(0);

            $table->timestamps();
            $table->softDeletes();
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
