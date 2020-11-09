<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftConstraintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draft_constraints', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('draft_id')->nullable();
            $table->integer('player_count')->nullable();
            $table->integer('min_rank')->nullable();
            $table->integer('max_rank')->nullable();
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
        Schema::dropIfExists('draft_constraints');
    }
}
