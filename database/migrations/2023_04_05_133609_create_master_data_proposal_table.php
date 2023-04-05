<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterDataProposalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal_logistics', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->unsignedInteger('amount')->default(0);
            $table->text('purpose_need')->nullable();
            $table->text('drop_off')->nullable();
            $table->timestamps();
        });

        Schema::create('proposal_figures', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('type')->nullable();
            $table->text('detail')->nullable();
            $table->mediumText('photo')->nullable();
            $table->timestamps();
        });

        Schema::create('proposal_banners', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('category')->nullable();
            $table->text('map_point')->nullable();
            $table->longText('content')->nullable();
            $table->timestamps();
        });

        Schema::create('proposal_events', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('type')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedInteger('mass_potential')->default(0);
            $table->timestamps();
        });

        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('category_code')->nullable();
            $table->string('status')->default('pending')->nullable();
            $table->text('reject_reason')->nullable();
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
        Schema::dropIfExists('proposal_logistics');
        Schema::dropIfExists('proposal_figures');
        Schema::dropIfExists('proposal_banners');
        Schema::dropIfExists('proposal_events');
        Schema::dropIfExists('proposals');
    }
}
