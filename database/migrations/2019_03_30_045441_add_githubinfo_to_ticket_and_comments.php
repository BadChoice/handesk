<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGithubinfoToTicketAndComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tickets', function (Blueprint $table) {
            $table->integer('github_issue_id')->default(0);
            $table->integer('github_issue_uuid')->default(0);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->integer('github_comment_id')->default(0);
            $table->integer('github_comment_uuid')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
