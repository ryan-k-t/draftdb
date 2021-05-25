<?php
namespace App\Libraries;

use App\Models\SeasonalPlayerRankingsAggregate;
use Illuminate\Support\Facades\DB;

class RankingsAggregator {

    static public function getPlayers( $season ){

        $query = DB::table('seasonal_player')
          ->join('players', 'players.id', '=', 'seasonal_player.player_id')
          ->leftJoin('classifications', 'classifications.id', '=', 'seasonal_player.classification_id')
          ->leftJoin('hand_types AS bats', 'bats.id', '=', 'seasonal_player.bats')
          ->leftJoin('hand_types AS throws', 'throws.id', '=', 'seasonal_player.throws')
          ->whereIn('seasonal_player.id',function($query) use($season) {
            $query->select('seasonal_player.id')
                  ->from('rankings')
                  ->join('ranking_instances', 'ranking_instances.id', '=', 'rankings.ranking_instance_id')
                  ->join('seasonal_player', 'seasonal_player.id', '=', 'rankings.seasonal_player_id')
                  ->where('ranking_instances.season', '=', $season);
          })
          ->orderBy('players.last_name', 'asc')
          ->orderBy('players.first_name', 'asc')
          ->select([
            'players.first_name',
            'players.last_name',
            'seasonal_player.school',
            'classifications.name AS classification',
            'seasonal_player.commitment',
            'seasonal_player.height',
            'seasonal_player.weight',
            'seasonal_player.age',
            'bats.name AS bats',
            'throws.name AS throws',
        ]);
        $results = $query->get();

        return $results;
          /*
        SELECT 
        players.first_name,
        players.last_name,
        seasonal_player.school,
        classifications.name,
        seasonal_player.commitment,
        seasonal_player.height,
        seasonal_player.weight,
        seasonal_player.age,
        bats.name AS bats,
        throws.name AS throws
        FROM seasonal_player
        JOIN players ON players.id = seasonal_player.player_id
        LEFT JOIN classifications ON classifications.id = seasonal_player.classification_id
        LEFT JOIN hand_types AS bats ON bats.id = seasonal_player.bats
        LEFT JOIN hand_types AS throws ON throws.id = seasonal_player.throws
        WHERE seasonal_player.id IN (
            SELECT DISTINCT(`seasonal_player_id`) 
            FROM rankings
            JOIN ranking_instances on ranking_instances.id = rankings.ranking_instance_id
            JOIN seasonal_player on seasonal_player.id = rankings.seasonal_player_id
            WHERE ranking_instances.season = 2021
        )
        */
    }

    function getInstances(){
        /* --- gets our most recent instances by source
        SELECT ranking_instances.id, ranking_instances.source_id, ranking_instances.date
        FROM ranking_instances 
        INNER JOIN (
            SELECT ranking_instances.source_id, MAX(ranking_instances.date) AS date
            FROM ranking_instances
            WHERE ranking_instances.season = 2021
            GROUP BY source_id
        ) AS self ON self.source_id = ranking_instances.source_id AND self.date = ranking_instances.date
        */
    }

    function allRankings()
    {
        /*
            SELECT sources.id, sources.name, ranking_instances.date, players.last_name, players.first_name, seasonal_player.id, rankings.rank, rankings.notes
            FROM ranking_instances
            JOIN sources ON sources.id = ranking_instances.source_id
            left JOIN rankings ON rankings.`ranking_instance_id` = ranking_instances.id
            JOIN seasonal_player ON seasonal_player.id = rankings.seasonal_player_id
            JOIN players ON players.id = seasonal_player.player_id
            WHERE ranking_instances.season = 2021
            ORDER BY players.last_name, players.first_name, source_id ASC, ranking_instances.date DESC;        
        */

    }

    /**
     * update a seasonal player's aggreate ranking
     *
     * @param int $seasonal_player_id
     * @param year $season
     * @return void
     */
    static public function aggregateForSeasonalPlayer( $seasonal_player_id , $season){
        /**
         * build a sub-query to find our most recent instances per source for this season
         */
        $subquery = DB::table('ranking_instances')
            ->select( "ranking_instances.source_id", DB::raw("MAX(ranking_instances.date) AS date"))
            ->where( 'ranking_instances.season', $season )
            ->groupBy('source_id');

        /**
         * run our main query to get our count and sum of rankings
         */
        $query = DB::table("rankings")
                   ->join('ranking_instances', 'ranking_instances.id', '=', 'rankings.ranking_instance_id')
                   ->join('seasonal_player', 'seasonal_player.id', '=', 'rankings.seasonal_player_id')
                   ->select(
                       'rankings.seasonal_player_id',
                       DB::raw('COUNT(rankings.seasonal_player_id) as ranking_count'),
                       DB::raw('SUM(rankings.rank) AS ranking_sum')
                   )
                   ->joinSub( $subquery, 'self', function( $join ){
                       $join->on('ranking_instances.source_id', '=', 'self.source_id');
                       $join->on('ranking_instances.date', '=', 'self.date');
                   })
                   ->where('rankings.seasonal_player_id', $seasonal_player_id)
                   ->groupBy('rankings.seasonal_player_id');
        $data = $query->first();
        // if nothing, bail
        $count = $data ? $data->ranking_count : 0;
        switch ($count) :
            case 0:
                SeasonalPlayerRankingsAggregate::where('seasonal_player_id', $seasonal_player_id )->delete();
                return;
                break;

            case 1:
                $average = $data->ranking_sum;
                break;

            default:
                $average = round( $data->ranking_sum / $data->ranking_count, 2);
                break;
        endswitch;

        SeasonalPlayerRankingsAggregate::updateOrCreate(
            ['seasonal_player_id' => $seasonal_player_id],
            [
                'rankings_count'   => $data->ranking_count,
                'rankings_sum'     => $data->ranking_sum,
                'rankings_average' => $average
            ]
        );
    }
}