<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Brackets\Media\HasMedia\ProcessMediaTrait;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class RankingInstance extends Model implements HasMedia
{
    use HasMediaCollectionsTrait;
    use ProcessMediaTrait;
    //use AutoProcessMediaTrait;

    protected $fillable = [
        'source_id',
        'season',
        'description',
        'date',
    ];
    
    protected $dates = [
        'date',
        'created_at',
        'updated_at',
    ];

    protected $with = ['source'];
    
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

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
    
    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/ranking-instances/'.$this->getKey());
    }
}
