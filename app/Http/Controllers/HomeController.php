<?php

namespace App\Http\Controllers;

use App\Libraries\RankingsAggregator;
use App\Models\RankingInstance;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /**
         * determine our current season
         */
        $currentSeason = env('currentSeason', date("Y"));

        /**
         * get a list of seasons
         */
        $availableSeasons = RankingInstance::select('season')
                                            ->distinct()
                                            ->orderBy('season', 'desc')
                                            ->pluck('season')
                                            ->toArray();

        /**
         * make sure the currentSeason value
         * is in our list of available Seasons
         */
        if( !in_array( $currentSeason, $availableSeasons) ):
            if( count( $availableSeasons ) > 0 ):
                $vals = array_values( $availableSeasons );
                $currentSeason = array_shift($vals);
            else:
                $currentSeason = null;
            endif;
        endif;

        /**
         * get our current season data
         */
        $data = RankingsAggregator::getPlayers( $currentSeason );
        return view('home', [
            'data'          => $data,
            'seasons'       => collect( $availableSeasons ),
            'currentSeason' => $currentSeason
        ] );
    }
}
