<?php

namespace App\Http\Controllers;

use App\Models\DraftEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class DraftController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param mixed $season
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $season = null)
    {
        if (is_null($season)) {
            $season = env('currentSeason', date("Y"));
        } else {
            if (!is_numeric($season)) {
                // bail
                throw new InvalidArgumentException('Season must be numeric');
            }

            $season = (int) $season;
        }

        // get optional URL query param
        // must be 0 or true
        $import = $request->input('import');
        if ($import === '1' || $import === 'true') {
            $do_import = true;
        } else {
            $do_import = false;
        }

        $source_data = $this->_retrieveData($season);

        if ($do_import) {
            $this->_processImport($source_data);
            return;
        }

        $csv_data = [
            [
                'Season',
                'Round',
                'Selection',
                'Team',
                'Position',
                'Last Name',
                'First Name',
                'Birthdate',
                'Age',
                'School',
                'SchoolClass',
                'Height',
                'Weight',
                'Bats',
                'Throws',
                'Report',
                'Pick Value',
                'Signing Bonus'
            ]
        ];

        foreach($source_data as $round) {
            foreach($round['picks'] as $pick) {

                $csv_data[] = [
                    $pick['year'],
                    $pick['pickRound'],
                    $pick['pickNumber'],
                    $pick['team']['name'],
                    Arr::get($pick, 'person.primaryPosition.abbreviation', ''), //$pick['person']['primaryPosition']['abbreviation'],
                    Arr::get($pick, 'person.useLastName', ''),  //$pick['person']['useLastName'],
                    Arr::get($pick, 'person.useName', ''), //$pick['person']['useName'],
                    Arr::get($pick, 'person.birthDate', ''), //$pick['person']['birthDate'],
                    Arr::get($pick, 'person.currentAge', ''), //$pick['person']['currentAge'],
                    Arr::get($pick, 'school.name', ''), //$pick['school']['name'],
                    Arr::get($pick, 'school.schoolClass', ''), //$pick['school']['schoolClass'],
                    Arr::get($pick, 'person.height', ''), //$pick['person']['height'],
                    Arr::get($pick, 'person.weight', ''), //$pick['person']['weight'],
                    Arr::get($pick, 'person.batSide.code', ''), //$pick['person']['batSide']['code'],
                    Arr::get($pick, 'person.pitchHand.code', ''), //$pick['person']['pitchHand']['code'],
                    isset($pick['blurb']) ? $pick['blurb'] : '',
                    $pick['pickValue'] ?? null,
                    $pick['signingBonus'] ?? null,
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

    private function _retrieveData($season) {
        //get the JSON ouutput from MLBAM
        $source_url = sprintf('https://statsapi.mlb.com/api/v1/draft/%d', $season);
        $response = Http::get($source_url);
        if (!$response->ok()) {
            return;
        }
        $data = $response->json();
        return $data['drafts']['rounds'];
    }

    private function _processImport($data) {
        foreach($data as $round) {
            foreach($round['picks'] as $pick) {
                DraftEntry::updateOrCreate(
                    [
                        'season' => $pick['year'],
                        'selection' => $pick['pickNumber']
                    ],
                    [
                        'position'     => Arr::get($pick, 'person.primaryPosition.abbreviation', ''),
                        'birthdate'    => Arr::get($pick, 'person.birthDate', ''),
                        'school'       => Arr::get($pick, 'school.name', ''),
                        'schoolClass'  => Arr::get($pick, 'school.schoolClass', ''),
                        'height'       => Arr::get($pick, 'person.height', ''),
                        'weight'       => Arr::get($pick, 'person.weight', ''),
                        'bats'         => Arr::get($pick, 'person.batSide.code', ''),
                        'throws'       => Arr::get($pick, 'person.pitchHand.code', ''),
                        'last_name'    => Arr::get($pick, 'person.useLastName', ''),
                        'first_name'   => Arr::get($pick, 'person.useName', ''),
                        'round'        => Arr::get($pick, 'pickRound', ''),
                        'team'         => Arr::get($pick, 'team.name', ''),
                        'team_id'      => Arr::get($pick, 'team.id', null),
                        'pickValue'    => Arr::get($pick, 'pickValue', null),
                        'signingBonus' => Arr::get($pick, 'signingBonus', null),
                        'signed'       => (isset($pick['signingBonus']) && $pick['signingBonus']) ? 1 : 0,
                    ]
                );
            }
        }
    }

    /* to match entries to  seasonal_players = 
    insert ignore into seasonal_player_draft_entries (
    seasonal_player_id,
    round,
    selection,
    team,
    team_id,
    `signed`
    )
    select seasonal_player.id, draft_entries.round, draft_entries.selection, draft_entries.team, draft_entries.team_id, draft_entries.signed
    from seasonal_player 
    join players on players.id = seasonal_player.player_id
    left join draft_entries on draft_entries.last_name = players.last_name and draft_entries.first_name = players.first_name and draft_entries.season = seasonal_player.season
    left join seasonal_player_draft_entries  on seasonal_player_draft_entries.seasonal_player_id = seasonal_player.id
    where seasonal_player.season = 2023 and seasonal_player_draft_entries.id is null and draft_entries.id is not null
    order by players.last_name, players.first_name
    */
}
