<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\SeasonalPlayerRankingsAggregate;
use App\Libraries\RankingsAggregator;
use Illuminate\Support\Facades\DB;

class AggregateRankings extends Command
{
    private $_season;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rankings:aggregate {season}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-run all aggregations of rankings for a given season';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $season = $this->argument('season');
        if( !is_numeric($season) ):
            $this->error("Season must be numeric!");
            return;
        endif;

        $this->_season = $this->argument('season');

        // purge all aggregates for the season provided
        $this->_purgeExistingRankings();

        // now get all seasonal players with at least one ranking
        $player_ids = $this->_getPlayersWithRankings();
        $id_count = count( $player_ids );
        $this->info( "Found ".$id_count." record".($id_count == 1 ? "" : "s")." to aggregate");
        foreach ($player_ids as $i => $player_id) :
            $this->info( "Processing record ". ($i + 1)." of ".$id_count);
            $success = RankingsAggregator::aggregateForSeasonalPlayer( $player_id, $this->_season );
            if (!$success) {
                $this->error("Could not aggregate for player id {$player_id}");
            }
        endforeach;

        $newCount = SeasonalPlayerRankingsAggregate::countForSeason( $this->_season );
        $this->info("There now " . ($newCount === 1 ? "is" : "are") . " " . $newCount." record" . ($newCount == 1 ? "" : "s"));
    }

    /**
     * purges all records for the _season as defined by the class property
     */
    private function _purgeExistingRankings( ){
        $this->line("Running for season: ".$this->_season);

        $originalCount = SeasonalPlayerRankingsAggregate::countForSeason( $this->_season );

        SeasonalPlayerRankingsAggregate::purgeBySeason( $this->_season );

        $updatedCount = SeasonalPlayerRankingsAggregate::countForSeason( $this->_season );

        $recordsDeleted = $originalCount - $updatedCount;
        $this->info("Purged ".$recordsDeleted." record".($recordsDeleted == 1 ? "" : "s"));
    }
    
    /**
     * get all the player IDs for the _season as defined by the class property
     *
     * @return array
     */
    private function _getPlayersWithRankings( ){
        $query = DB::table('seasonal_player')
            ->join('rankings', 'rankings.seasonal_player_id', '=', 'seasonal_player.id')
            ->where('seasonal_player.season',$this->_season)
            ->select('seasonal_player.id');
        $results = $query->get()->unique()->pluck("id");
        return $results;
    }
}
