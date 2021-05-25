<?php

namespace App\Http\Requests\Admin\Ranking;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreRanking extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.ranking.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'seasonal_player_id' => ['required', Rule::unique('rankings', 'seasonal_player_id'), 'string'],
            'ranking_instance_id' => ['required', Rule::unique('rankings', 'ranking_instance_id'), 'string'],
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
