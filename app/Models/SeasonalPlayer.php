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
        'age',
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];


    public function positions(){
        return $this->belongsToMany(Position::class, 'seasonal_player_positions');
    }
    public function batType(){
        return $this->belongsTo(HandType::class, null, 'bats');
    }
    public function throwType(){
        return $this->belongsTo(HandType::class, null, 'throws');
    }
    public function classification(){
        return $this->belongsTo(Classification::class);
    }
    public function player(){
        return $this->belongsTo(Player::class);
    }
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/seasonal-players/'.$this->getKey());
    }
}
