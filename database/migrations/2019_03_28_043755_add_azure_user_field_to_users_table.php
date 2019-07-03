<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAzureUserFieldToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('displayName')->nullable();
            $table->string('givenName')->nullable();
            $table->string('jobTitle')->nullable();
            $table->string('businessPhones')->nullable();
            $table->string('mail')->nullable();
            $table->string('mobilePhone')->nullable();
            $table->string('officeLocation')->nullable();
            $table->string('preferredLanguage')->nullable();
            $table->boolean('accountEnabled')->default(false);
            $table->string('country')->nullable();
            $table->string('telephoneNumber')->nullable();
            $table->string('userType')->nullable();
            $table->string('surname')->nullable();
            $table->string('userPrincipalName')->nullable();
            $table->string('azure_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}