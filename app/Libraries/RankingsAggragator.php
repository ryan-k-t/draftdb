<?php
namespace App\Libraries;

use Illuminate\Support\Facades\DB;

class RankingsAggragator {
    public function getPlayers( $season ){

        $query = DB::table('seasonal_player')
          ->join('players', 'players.id', '=', 'seasonal_player.player_id')
          ->leftJoin('classifications', 'classifications.id', '=', 'seasonal_player.classification_id')
          ->leftJoin('handTypes AS bats', 'bats.id', '=', 'seasonal_player.bats')
          ->leftJoin('handTypes AS throws', 'throws.id', '=', 'seasonal_player.throws')
          ->whereIn('seasonal_player.id',function($query) use($season) {
            $query->select('user_id')
                  ->from('rankings')
                  ->join('ranking_instances', 'ranking_instances.id', '=', 'rankings.ranking_instance_id')
                  ->join('seasonal_player', 'seasonal_player.id', '=', 'rankings.seasonal_player_id')
                  ->where('ranking_instances.season', '=', $season);
          })
          ->select([
            'players.first_name',
            'players.last_name',
            'seasonal_player.school',
            'classifications.name',
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
}