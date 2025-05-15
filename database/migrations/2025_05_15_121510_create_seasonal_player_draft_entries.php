<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeasonalPlayerDraftEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seasonal_player_draft_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seasonal_player_id')->references('id')->on('seasonal_player');
            $table->string('round');
            $table->unsignedSmallInteger('selection');
            $table->string('team');
            $table->unsignedSmallInteger('team_id')->nullable();
            $table->boolean('signed')->default(false);
            $table->timestamps();
            $table->unique('seasonal_player_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seasonal_player_draft_entries');
    }
}
