<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

use App\Models\Ranking;

class RankingDeleted
{
    use SerializesModels;

    public $ranking;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Ranking $ranking)
    {
        $this->ranking = $ranking;
    }
}
