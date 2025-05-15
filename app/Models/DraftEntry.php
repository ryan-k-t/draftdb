<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DraftEntry extends Model
{
    protected $fillable = [
        'seasonal_player_id',
        'season',
        'position',
        'birthdate',
        'school',
        'schoolClass',
        'height',
        'weight',
        'bats',
        'throws',
        'last_name',
        'first_name',
        'round',
        'team',
        'team_id',
        'selection',
        'signed',
        'pickValue',
        'signingBonus'
    
    ];

    protected $table = 'draft_entries';

    public $timestamps = true;
}
