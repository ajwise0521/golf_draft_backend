<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeagueMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('league_id')->nullable();
            $table->uuid('user_id')->nullable();
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
        Schema::table('league_members', function (Blueprint $table) {
            //
        });
    }
}
