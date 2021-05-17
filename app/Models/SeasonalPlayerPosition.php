<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeasonalPlayerPosition extends Model
{
    protected $fillable = [
        'seasonal_player_id',
        'position_id',
    
    ];
    
    
    protected $dates = [
    
    ];
    public $timestamps = false;
    
    protected $appends = ['resource_url'];

    public function position(){
        return $this->belongsTo(Position::class);
    }
    public function seasonalPlayer(){
        return $this->belongsTo(SeasonalPlayer::class);
    }

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/seasonal-player-positions/'.$this->getKey());
    }
}
