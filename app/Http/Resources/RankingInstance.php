<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RankingInstance extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $date = new Carbon( $this->date );
        return [
            'date'         => $date->toDateString(),
            'id'           => $this->id,
            'resource_url' => $this->resource_url,
            'season'       => $this->season,
            'source_id'    => $this->source_id,
            'source'       => $this->source,
            'description'  => $this->description
        ];
    }
}
