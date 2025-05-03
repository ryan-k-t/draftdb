<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DraftController extends Controller
{
    //
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $season = 2024;
        //get the JSON ouutput from MLBAM
        $source_url = sprintf('https://statsapi.mlb.com/api/v1/draft/?year=%d', $season);
        $response = Http::get($source_url);
        if (!$response->ok()) {
            return;
        }
        $data = $response->json();

        $csv_data = [
            [
                'Round',
                'Selection',
                'Team',
                'Position',
                'Last Name',
                'First Name',
                'Birthdate',
                'Age',
                'School',
                'SchoollClass',
                'Height',
                'Weight',
                'Bats',
                'Throws',
                'Report',
            ]
        ];
        $rounds = $data['drafts']['rounds'];

        foreach($rounds as $round) {
            foreach($round['picks'] as $pick) {

                $csv_data[] = [
                    $pick['pickRound'],
                    $pick['pickNumber'],
                    $pick['team']['name'],
                    $pick['person']['primaryPosition']['abbreviation'],
                    $pick['person']['useLastName'],
                    $pick['person']['useName'],
                    $pick['person']['birthDate'],
                    $pick['person']['currentAge'],
                    $pick['school']['name'],
                    $pick['school']['schoolClass'],
                    $pick['person']['height'],
                    $pick['person']['weight'],
                    $pick['person']['batSide']['code'],
                    $pick['person']['pitchHand']['code'],
                    isset($pick['blurb']) ? $pick['blurb'] : ''
                ];
            }
        }

        header('Content-Type: text/csv; charset=utf-8');
        header( sprintf('Content-Disposition: attachment; filename=mlbdraft-%d.csv', $season) );
        
        $output = fopen('php://output', 'w');
        foreach($csv_data as $row) {
            fputcsv($output, $row);
        }

        fclose($output);
    }
}
