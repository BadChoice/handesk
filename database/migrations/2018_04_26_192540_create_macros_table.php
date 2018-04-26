<?php

use App\Macro;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMacrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('macros', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('available_to')->default(Macro::AVAILABLE_TO_ME);
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('team_id')->nullable();

            $table->text("title");
            $table->text('body');
            $table->unsignedInteger('new_status')->nullable();
            $table->unsignedInteger('assign_id')->nullable();
            $table->unsignedInteger('team_assign_id')->nullable();

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
        Schema::dropIfExists('macros');
    }
}
