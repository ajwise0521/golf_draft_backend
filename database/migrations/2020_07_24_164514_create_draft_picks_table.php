<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftPicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draft_picks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('draft_id')->nullable();
            $table->uuid('user_id')->nullable();
            $table->uuid('player_id')->nullable();
            $table->integer('draft_pick')->nullable();
            $table->timestamps();
            $table->datetime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('draft_picks', function (Blueprint $table) {
            //
        });
    }
}
