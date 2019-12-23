<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKpisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kpis', function (Blueprint $table) {
            $table->primary(['date', 'type', 'relation_id', 'kpi']);
            $table->date('date');
            $table->tinyInteger('type');
            $table->tinyInteger('kpi');
            $table->unsignedInteger('relation_id');
            $table->unsignedInteger('total')->default(0);
            $table->unsignedInteger('count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kpis');
    }
}
