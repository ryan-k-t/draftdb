<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Brackets\Media\HasMedia\ProcessMediaTrait;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class RankingInstance extends Model implements HasMedia
{
    use HasMediaCollectionsTrait;
    use ProcessMediaTrait;
    //use AutoProcessMediaTrait;

    protected $fillable = [
        'source_id',
        'season',
        'date',
    ];
    
    
    protected $dates = [
        'date',
        'created_at',
        'updated_at',
    ];
    
    protected $appends = ['resource_url'];

    public function source() {
        return $this->belongsTo(Source::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('import_file')
             ->maxNumberOfFiles(1)
             ->private()
             ->accepts( 'text/plain', 'text/csv' );
    }
    
    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/ranking-instances/'.$this->getKey());
    }
}
