<?php

use App\Idea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ideas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('requester_id');
            $table->tinyInteger('status')->unsigned()->default(Idea::STATUS_NEW);
            $table->string('title');

            $table->string('repository')->nullable();
            $table->unsignedInteger('issue_id')->nullable();

            $table->date('due_date')->nullable();
            $table->text('body');
            $table->tinyInteger('development_effort')->unsigned()->default(0);
            $table->tinyInteger('sales_impact')->unsigned()->default(0);
            $table->tinyInteger('current_impact')->unsigned()->default(0);
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
        Schema::dropIfExists('ideas');
    }
}
