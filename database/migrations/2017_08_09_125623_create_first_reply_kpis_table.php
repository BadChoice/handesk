<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirstReplyKpisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('first_reply_kpis', function (Blueprint $table) {
            $table->primary(["date","type","relation_id"]);
            $table->date('date');
            $table->tinyInteger('type');
            $table->unsignedInteger('relation_id');
            $table->unsignedInteger('avg')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('first_reply_kpis');
    }
}
