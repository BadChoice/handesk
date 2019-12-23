<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRatingToTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->tinyInteger('rating')->after('level')->nullable();
        });

        Schema::table('user_settings', function (Blueprint $table) {
            $table
                ->boolean('ticket_rated_notification')
                ->after('mention_notification')
                ->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('rating');
        });

        Schema::table('user_settings', function (Blueprint $table) {
            $table->dropColumn('ticket_rated_notification');
        });
    }
}
