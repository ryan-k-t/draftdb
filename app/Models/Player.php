<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'preferred_name',
        'date_of_birth',
    
    ];
    
    
    protected $dates = [
        'date_of_birth',
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/players/'.$this->getKey());
    }
}
