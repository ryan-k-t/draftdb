<?php

namespace App\Observers;

use App\Models\SeasonalPlayer;
use App\Models\SeasonalPlayerRankingsAggregate;

class SeasonalPlayerObserver
{

    /**
     * Handle the seasonal player "deleted" event.
     *
     * @param  \App\SeasonalPlayer  $seasonalPlayer
     * @return void
     */
    public function deleted(SeasonalPlayer $seasonalPlayer)
    {
        SeasonalPlayerRankingsAggregate::where('seasonal_player_id', $seasonalPlayer->id)->delete();
    }
}
