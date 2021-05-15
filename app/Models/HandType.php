<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HandType extends Model
{
    protected $fillable = [
        'name',
    
    ];
    
    
    protected $dates = [
    
    ];
    public $timestamps = false;
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/hand-types/'.$this->getKey());
    }
}
