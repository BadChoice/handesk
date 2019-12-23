<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->boolean('daily_tasks_notification')->default(true);
            $table->string('tickets_signature')->nullable();

            $table->boolean('new_ticket_notification')->default(true);
            $table->boolean('ticket_assigned_notification')->default(true);
            $table->boolean('ticket_updated_notification')->default(true);
            $table->boolean('new_lead_notification')->default(true);
            $table->boolean('lead_assigned_notification')->default(true);
            $table->boolean('new_idea_notification')->default(true);
            $table->boolean('mention_notification')->default(true);

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
        Schema::dropIfExists('user_settings');
    }
}
