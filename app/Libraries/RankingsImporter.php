<?php

namespace App\Libraries;

use App\Helpers\ConversionHelper;
use App\Models\Classification;
use App\Models\HandType;
use App\Models\Player;
use App\Models\Position;
use App\Models\Ranking;
use App\Models\RankingInstance;
use App\Models\SeasonalPlayer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class RankingsImporter {
    private $_instance;
    private $_importFile;
    private $_errors;

    private $_handTypes = [];
    private $_classifications = [];
    private $_positions = [];

    /**
     * construct
     *
     * @param RankingInstance $instance the RankingsInstance record this import belongs to
     * @param String $importFile the filename of the import file
     */
    public function __construct( RankingInstance $instance, String $importFile ){
        $this->_instance = $instance;
        $this->_importFile = $importFile;

        $this->_initializeErrors();

        $this->_initializeOptions();
    }

    /**
     * resets the list of errors
     *
     * @return void
     */
    private function _initializeErrors(){
        $this->_errors = [];
    }

    /**
     * add an error to the local array
     *
     * @param string $error
     * @return void
     */
    private function _addError( $error ){
        $this->_errors[] = $error;
    }

    /**
     * check if any errors have been registered
     *
     * @return boolean
     */
    public function hasErrors(){
        return count( $this->_errors ) > 0;
    }

    /**
     * getter for private errors
     *
     * @return array
     */
    public function getErrors(){
        return $this->_errors;
    }

    /**
     * set the local values for our relational data
     *
     * @return void
     */
    private function _initializeOptions(){
        $this->_classifications = Classification::select('id', 'name')->get()->mapWithKeys(function( $item ){
            return [$item['name'] => $item['id']];
        })->toArray();

        $this->_positions = Position::select('id', 'name')->get()->mapWithKeys(function($item){
            return [$item['name'] => $item['id']];
        })->toArray();

        $this->_handTypes = HandType::select('id', 'name' )->get()->mapWithKeys(function($item){
            return [$item['name'] => $item['id']];
        })->toArray();
    }

    /**
     * process the file for the instance ID set on the construct
     *
     * @return array if the array is empty --- SUCCESS, otherwise it will be a list of errors
     */
    public function process(){
        Log::debug( __FUNCTION__ );

        $importFilePath = storage_path('uploads') . "/" . $this->_importFile;
        if( ($fileHandle = fopen($importFilePath, 'r') ) === FALSE ):
            $this->_addError( "Cannot access import file" );
            return $this->_errors;
        endif;

        /**
         * file should have a header row, let's skip that
         */
        $counter = 1;
        while ( ($row = fgetcsv( $fileHandle ) ) !== false ) :
            // skip header row
            if( $counter > 1 ):
                $this->_processRow( $row, $counter );
            endif;

            $counter++;
        endwhile;

        return $this->_errors;
    }

    private function _processRow( $data, $counter ){
        Log::debug( "processing row ".$counter);
        Log::debug( print_r($data, true) );
        /**
         * columns:
         *  rank
         *  last name
         *  first name
         *  school (college or town?)
         *  class
         *  position(s) separated by /
         *  height (f-i)
         *  weight
         *  bats
         *  throws
         *  commitment
         *  age (decimal)
         *  notes (if applicable)
         */
        list(
            $rank,
            $lastName,
            $firstName,
            $from,
            $classification,
            $positions,
            $height,
            $weight,
            $bats,
            $throws,
            $commitment,
            $age,
            $notes
        ) = $data;

        // find/create Player
        $player = Player::firstOrCreate(
            [
                'first_name' => $firstName,
                'last_name'  => $lastName
            ]
        );

        // find/create SeasonalPlayer
        $seasonalPlayer = SeasonalPlayer::firstOrCreate(
            [
                'season'    => $this->_instance->season,
                'player_id' => $player->id
            ],
            [
                'school'            => $from,
                //'city'              => '',
                //'state'             => '',
                'classification_id' => Arr::get( $this->_classifications, $classification, 0),
                'commitment'        => $commitment,
                'height'            => ConversionHelper::heightToInches( $height ),
                'weight'            => (integer) $weight,
                'bats'              => Arr::get( $this->_handTypes, $bats, 0),
                'throws'            => Arr::get( $this->_handTypes, $throws, 0),
                'age'               => $age ? $age : null
            ]
        );

        // update SeasonalPlayer position(s)
        $position_list = explode( "/", $positions );
        $position_ids = collect( $position_list )->map(function( $item ) {
            return Arr::get( $this->_positions, $item );
        });
        $position_ids = $position_ids->filter(function($item){
            return !is_null( $item );
        });
        if( $position_ids ):
            $seasonalPlayer->positions()->syncWithoutDetaching( $position_ids->all() );
        endif;

        // create ranking
        Ranking::create([
            'seasonal_player_id'  => $seasonalPlayer->id,
            'ranking_instance_id' => $this->_instance->id,
            'rank'                => $rank,
            'notes'               => $notes
        ]);
    }


    
}