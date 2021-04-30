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
            $table->timestamps();
        });
        Schema::create('ranking_instances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id');
            $table->year('season');
            $table->date('date');
            $table->timestamps();
        });
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('preferred_name');
            $table->date('date_of_birth');
            $table->timestamps();
        });
        Schema::create('seasonal_player', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id');
            $table->year('season');
            $table->string('school');
            $table->string('city');
            $table->string('state');
            $table->foreignId('classification_id')->index();
            $table->string('commitment');
            $table->unsignedInteger('height')->nullable();
            $table->unsignedInteger('weight')->nullable();
            $table->enum('bats', ['R', 'L', 'S']);
            $table->enum('throws', ['R', 'L', 'S']);
            $table->timestamps();
            $table->unique(['player_id','season']);
        });
        Schema::create('classifications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('rankings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seasonal_player_id');
            $table->foreignId('ranking_instance_id');
            $table->unsignedInteger('rank')->index();
            $table->timestamps();
            $table->unique(['seasonal_player_id','ranking_instance_id']);
        });
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('seasonal_player_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seasonal_player_id');
            $table->foreignId('position_id');
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
