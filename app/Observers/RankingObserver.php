<?php

namespace App\Observers;

use App\Libraries\RankingsAggregator;
use App\Models\Ranking;

class RankingObserver
{
    /**
     * Handle the ranking "saved" event.
     *
     * @param  \App\Models\Ranking  $ranking
     * @return void
     */
    public function saved(Ranking $ranking)
    {
        RankingsAggregator::aggregateForSeasonalPlayer( $ranking->seasonal_player_id, $ranking->ranking_instance->season );
    }

    /**
     * Handle the ranking "deleted" event.
     *
     * @param  \App\Models\Ranking  $ranking
     * @return void
     */
    public function deleted(Ranking $ranking)
    {
        RankingsAggregator::aggregateForSeasonalPlayer( $ranking->seasonal_player_id, $ranking->ranking_instance->season );
    }
}
