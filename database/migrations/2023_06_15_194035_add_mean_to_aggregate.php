<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMeanToAggregate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seasonal_player_rankings_aggregate', function (Blueprint $table) {
            $table->unsignedDouble('rankings_mean', 5, 2)->nullable()->after('rankings_average');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seasonal_player_rankings_aggregate', function (Blueprint $table) {
            $table->dropColumn('rankings_mean');
        });
    }
}
