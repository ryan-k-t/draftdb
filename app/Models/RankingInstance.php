<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RankingInstance extends Model
{
    protected $fillable = [
        'source_id',
        'season',
        'date',
    
    ];
    
    
    protected $dates = [
        'season',
        'date',
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    public function source() {
        return $this->belongsTo(Source::class);
    }
    
    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/ranking-instances/'.$this->getKey());
    }
}
