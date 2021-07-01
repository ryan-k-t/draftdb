<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeasonalPlayerRankingsAggregate extends Model
{
    protected $table = 'seasonal_player_rankings_aggregate';
    protected $fillable = [
        'seasonal_player_id',
        'rankings_sum',
        'rankings_count',
        'rankings_average'
    ];
    public function seasonalPlayer(){
        return $this->belongsTo(SeasonalPlayer::class);
    }

    /**
     * purge all records for a given season
     *
     * @param int $season
     * @return void
     */
    public static function purgeBySeason( $season ){
        $myTable = self::getTableName();
        self::join('seasonal_player','seasonal_player.id', '=', $myTable.'.seasonal_player_id')
            ->where('seasonal_player.season', $season)
            ->delete();
    }

    /**
     * retrieve a count of records for the given season
     *
     * @param int $season
     * @return int
     */
    public static function countForSeason( $season ){
        $myTable = self::getTableName();
        return self::join('seasonal_player','seasonal_player.id', '=', $myTable.'.seasonal_player_id')
                   ->where('seasonal_player.season', $season)
                   ->count();
    }

    /**
     * helper to get table name statically
     *
     * @return string
     */
    public static function getTableName(){
        return (new self())->getTable();
    }
}
