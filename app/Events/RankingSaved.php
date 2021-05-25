<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

use App\Models\Ranking;

class RankingSaved
{
    use SerializesModels;

    public $ranking;

    /**
     * Create a new event instance.
     * 
     * @param \App\Models\Ranking $ranking
     *
     * @return void
     */
    public function __construct(Ranking $ranking)
    {
        $this->ranking = $ranking;
    }
}
