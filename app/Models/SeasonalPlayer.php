<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeasonalPlayer extends Model
{
    protected $table = 'seasonal_player';

    protected $fillable = [
        'player_id',
        'season',
        'school',
        'city',
        'state',
        'classification_id',
        'commitment',
        'height',
        'weight',
        'bats',
        'throws',
    
    ];
    
    
    protected $dates = [
        'season',
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/seasonal-players/'.$this->getKey());
    }
}
