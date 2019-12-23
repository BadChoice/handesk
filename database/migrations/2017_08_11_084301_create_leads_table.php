<?php

use App\Lead;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->nullable();

            $table->integer('status')->default(Lead::STATUS_NEW);

            $table->unsignedInteger('team_id')->unsigned()->nullable();
            $table->unsignedInteger('user_id')->unsigned()->nullable();

            $table->string('name');
            $table->text('body')->nullable();

            $table->string('username')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('company')->nullable();
            $table->string('phone')->nullable();

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
        Schema::dropIfExists('leads');
    }
}
