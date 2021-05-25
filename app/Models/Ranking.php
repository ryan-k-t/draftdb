<?php

namespace App\Models;

use App\Events\RankingSaved;
use App\Events\RankingDeleted;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Ranking extends Model
{
    use Notifiable;

    protected $fillable = [
        'seasonal_player_id',
        'ranking_instance_id',
        'rank',
        'notes'
    ];
    
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $with = [
        'seasonal_player',
        'ranking_instance'
    ];
    
    protected $dispatchesEvents = [
        'saved' => RankingSaved::class,
        'deleted' => RankingDeleted::class
    ];

    protected $appends = ['resource_url'];


    public function seasonal_player() {
        return $this->belongsTo(SeasonalPlayer::class);
    }

    public function ranking_instance() {
        return $this->belongsTo(RankingInstance::class);
    }

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/rankings/'.$this->getKey());
    }
}
