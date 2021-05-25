<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SeasonalPlayer extends Model
{
    use Notifiable;

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

    protected $with = ['player'];

    protected $dispatchesEvents = [
        'deleted' => App\Events\SeasonalPlayerDeleted::class
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
