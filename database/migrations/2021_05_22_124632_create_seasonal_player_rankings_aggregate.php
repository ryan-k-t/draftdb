<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeasonalPlayerRankingsAggregate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seasonal_player_rankings_aggregate', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seasonal_player_id')->references('id')->on('seasonal_player');
            $table->unsignedSmallInteger('rankings_count');
            $table->unsignedInteger('rankings_sum');
            $table->unsignedDouble('rankings_average', 5, 2);
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
        Schema::dropIfExists('seasonal_player_rankings_aggregate');
    }
}
