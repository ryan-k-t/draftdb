<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeasonalPlayerDraftEntry extends Model
{
    protected $fillable = [
        'seasonal_player_id',
        'round',
        'team',
        'selection',
        'signed'
    
    ];

    protected $table = 'seasonal_player_draft_entries';

    public $timestamps = true;

    protected $appends = ['resource_url'];

    public function seasonalPlayer(){
        return $this->belongsTo(SeasonalPlayer::class);
    }

}
