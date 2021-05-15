<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoreSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });
        Schema::create('ranking_instances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->references('id')->on('sources');
            $table->year('season')->index();
            $table->date('date')->index();
            $table->timestamps();
        });
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('preferred_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->timestamps();
        });
        Schema::create('classifications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });
        Schema::create('hand_types', function (Blueprint $table) {
            $table->id();
            $table->char('name')->unique();
        });
        Schema::create('seasonal_player', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->references('id')->on('players');
            $table->year('season');
            $table->string('school')->nullable();
            $table->string('city');
            $table->string('state');
            $table->foreignId('classification_id')->references('id')->on('classifications');
            $table->string('commitment')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->unsignedInteger('weight')->nullable();
            $table->foreignId('bats')->references('id')->on('hand_types');
            $table->foreignId('throws')->references('id')->on('hand_types');
            $table->timestamps();
            $table->unique(['player_id','season']);
        });
        Schema::create('rankings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seasonal_player_id')->references('id')->on('seasonal_player');
            $table->foreignId('ranking_instance_id')->references('id')->on('ranking_instances');
            $table->unsignedInteger('rank')->index();
            $table->timestamps();
            $table->unique(['seasonal_player_id','ranking_instance_id']);
        });
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });
        Schema::create('seasonal_player_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seasonal_player_id')->references('id')->on('seasonal_player');
            $table->foreignId('position_id')->references('id')->on('positions');
            $table->unique(['seasonal_player_id','position_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sources');
        Schema::dropIfExists('ranking_instances');
        Schema::dropIfExists('players');
        Schema::dropIfExists('seasonal_player');
        Schema::dropIfExists('classifications');
        Schema::dropIfExists('rankings');
        Schema::dropIfExists('positions');
        Schema::dropIfExists('seasonal_player_positions');
    }
}
