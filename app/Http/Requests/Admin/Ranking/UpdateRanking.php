<?php

namespace App\Http\Requests\Admin\Ranking;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UpdateRanking extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.ranking.edit', $this->ranking);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        Log::debug(__FUNCTION__);
        Log::debug($this->ranking->getKey());
        Log::debug($this->ranking->getKeyName());
        Log::debug( "seasonal_player_id: ".$this->ranking->seasonal_player_id);
        return [
            //'seasonal_player_id' => 'required|unique:rankings,seasonal_player_id,NULL,id,ranking_instance_id,'.$this->ranking->ranking_instance_id,
            'seasonal_player_id' => ['integer', 'required', Rule::unique('rankings', 'seasonal_player_id')->where( function($query){
                return $query->where('ranking_instance_id', $this->ranking->ranking_instance_id)->where('id', '<>', $this->id);
            })],
            //'ranking_instance_id' => ['required', Rule::unique('rankings', 'ranking_instance_id')->ignore($this->ranking->getKey(), $this->ranking->getKeyName()), 'string'],
            'rank' => ['required', 'integer'],
            
        ];
    }

    public function getSeasonalPlayerId(){
        if( $this->has('seasonal_player')){
            return $this->get('seasonal_player')['id'];
        }
    }
    public function getRankingInstanceId(){
        if( $this->has('ranking_instance')){
            return $this->get('ranking_instance')['id'];
        }
    }
    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();


        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
