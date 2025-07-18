<?php
namespace App\Libraries;

use App\Models\SeasonalPlayerRankingsAggregate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RankingsAggregator {

    const RANKING_SEPARATOR = '|';

    /**
     * get all the rankings 
     * for a given season
     *
     * @param year $season
     * @return array
     */
    static public function getPlayers( $season ){

        $query = DB::table('seasonal_player')
          ->join('players', 'players.id', '=', 'seasonal_player.player_id')
          ->leftJoin('classifications', 'classifications.id', '=', 'seasonal_player.classification_id')
          ->leftJoin('hand_types AS bats', 'bats.id', '=', 'seasonal_player.bats')
          ->leftJoin('hand_types AS throws', 'throws.id', '=', 'seasonal_player.throws')
          ->leftJoin('seasonal_player_draft_entries', 'seasonal_player_draft_entries.seasonal_player_id', '=', 'seasonal_player.id')
          ->join('seasonal_player_rankings_aggregate', 'seasonal_player_rankings_aggregate.seasonal_player_id', '=', 'seasonal_player.id')
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
            'seasonal_player.id',
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
            'seasonal_player_rankings_aggregate.rankings_count',
            'seasonal_player_rankings_aggregate.rankings_average',
            'seasonal_player_rankings_aggregate.rankings_mean',
            'seasonal_player_draft_entries.signed',
            'seasonal_player_draft_entries.round',
            'seasonal_player_draft_entries.selection',
            'seasonal_player_draft_entries.team',
            DB::raw('( SELECT GROUP_CONCAT(`positions`.`name` SEPARATOR "/") 
                FROM `seasonal_player_positions` 
                JOIN `positions` ON `positions`.`id` = `seasonal_player_positions`.`position_id`
                WHERE `seasonal_player_positions`.`seasonal_player_id` = `seasonal_player`.`id` ) AS `positions`'
            )
          ]);
        $results = $query->get();

        return $results->map( function($item){
            $item->rankings = self::getSeasonalPlayerRankings( $item->id );
            return $item;
        });

    }

    /**
     * get all the rankings for a seasonal player
     * 
     * rankings are sorted by source name and date
     *
     * @param int $seasonal_player_id
     * @return array
     */
    static function getSeasonalPlayerRankings( $seasonal_player_id ){
        $query = DB::table('rankings')
          ->join('ranking_instances', 'ranking_instances.id', '=', 'rankings.ranking_instance_id')
          ->join('sources', 'sources.id', '=', 'ranking_instances.source_id')
          ->join('seasonal_player', 'seasonal_player.id', '=', 'rankings.seasonal_player_id')
          ->where('seasonal_player.id',$seasonal_player_id)
          ->orderBy('sources.name', 'asc')
          ->orderBy('ranking_instances.date', 'desc')
          ->select([
            'sources.id AS source_id',
            'sources.name AS source', 
            'ranking_instances.date',
            'ranking_instances.description',
            'rankings.rank',
            'rankings.notes'
          ]);
        $results = $query->get();

        $return = [];
        $results->each( function( $item ) use(&$return) {
            if( count( $return ) == 0):
                array_push( $return, [
                    'source_id'   => $item->source_id,
                    'source_name' => $item->source,
                    'history'     => [ $item ]
                ]);
            else:
                $key = array_search( $item->source_id, array_column($return, 'source_id'));
                if( $key === false ):
                    array_push( $return, [
                        'source_id'   => $item->source_id,
                        'source_name' => $item->source,
                        'history'     => [ $item ]
                    ]);
                else:
                    $return[ $key ]['history'][] = $item;
                endif;
            endif;
        });
        return $return;
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
                       DB::raw('SUM(rankings.rank) AS ranking_sum'),
                       DB::raw('GROUP_CONCAT(rankings.rank SEPARATOR \'' . self::RANKING_SEPARATOR . '\') AS rankings')
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
        if ($count === 0) {
            SeasonalPlayerRankingsAggregate::where('seasonal_player_id', $seasonal_player_id )->delete();
            return false;
        }

        $average = $count === 1 ? $data->ranking_sum : round( $data->ranking_sum / $data->ranking_count, 2);
        $rankings = self::parse_rankings($data->rankings);
        if ($rankings) {
            $mean = self::generate_mean($rankings);
        } else {
            $mean = null;
        }

        SeasonalPlayerRankingsAggregate::updateOrCreate(
            ['seasonal_player_id' => $seasonal_player_id],
            [
                'rankings_count'   => $data->ranking_count,
                'rankings_sum'     => $data->ranking_sum,
                'rankings_average' => $average,
                'rankings_mean'    => $mean,
            ]
        );

        return true;
    }

    /**
     * parses the returned DB value into an array of integers
     *
     * @param string $values_string
     * @return []int|null
     */
    private static function parse_rankings($values_string) {
        $values = explode(self::RANKING_SEPARATOR, $values_string);
        if  (!$values || !is_array($values)) {
            return null;
        }

        // make sure they're all ints
        $ints = array_map(function($item) {
            return intval($item);
        }, $values);

        // remove the empties
        $int_values = array_filter($ints);

        return $int_values;
    }

    /**
     * generates the mean from a list of numbers
     *
     * @param [type] $values_string
     * @return void
     */
    private static function generate_mean($values) {
        $value_count = count($values);
        if ($value_count === 0) {
            return;
        }
        if ($value_count === 1) {
            return array_shift($values);
        }

        // sort
        asort($values);

        switch (true) {
            case $value_count === 1:
                $response = array_pop($values);
                break;
            case $value_count === 2:
            case $value_count === 3:
                // get average of high and low values
                $high_value = array_pop($values);
                $low_value = array_shift($values);
                $response = round(($high_value + $low_value) / 2, 2);
                break;
            case $value_count > 3;
                // remove the high value
                $high_value = array_pop($values);
                // remove the low value
                $low_value = array_shift($values);
                $response = round(array_sum($values) / count($values), 2);
                break;
            default:
                $response = null;
                break;
        }
        
        return $response;
    }
}