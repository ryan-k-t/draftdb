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
}
