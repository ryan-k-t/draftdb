<?php

namespace App\Events;

use App\Models\SeasonalPlayer;
use Illuminate\Queue\SerializesModels;

class SeasonalPlayerDeleted
{
    use SerializesModels;

    public $seasonalPlayer;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(SeasonalPlayer $seasonalPlayer)
    {
        $this->seasonalPlayer = $seasonalPlayer;
    }
}
