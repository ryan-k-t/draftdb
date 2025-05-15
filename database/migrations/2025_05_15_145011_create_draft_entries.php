<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draft_entries', function (Blueprint $table) {
            $table->id();
            $table->year('season');
            $table->string('round');
            $table->unsignedSmallInteger('selection');
            $table->string('team');
            $table->unsignedSmallInteger('team_id')->nullable();
            $table->unsignedInteger('seasonal_player_id')->nullable()->index();
            $table->string('position');
            $table->string('birthdate');
            $table->string('school');
            $table->string('schoolClass');
            $table->string('height');
            $table->string('weight');
            $table->string('bats');
            $table->string('throws');
            $table->string('last_name');
            $table->string('first_name');
            $table->boolean('signed')->default(false);
            $table->unsignedInteger('pickValue')->nullable();
            $table->unsignedInteger('signingBonus')->nullable();
            $table->timestamps();
            $table->unique(['season', 'selection']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('draft_entries');
    }
}
