<?php

namespace App\Http\Controllers;

use App\Libraries\RankingsAggregator;
use Illuminate\Http\Request;

class RankingsController extends Controller
{
    /**
     * pull transactions for a given date
     *
     * @param Request $request
     * @return JSON
     */
    function getBySeason(Request $request)
    {
        $validated = $request->validate([
            'season' => 'date_format:Y',
        ]);

        $data = RankingsAggregator::getPlayers( $validated['season'] );
        $response = [
            'success' => TRUE,
            'records' => $data,
        ];

        return response()->json($response);
    }
}