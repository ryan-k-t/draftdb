<?php

namespace App\Http\Requests\Admin\SeasonalPlayerPosition;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreSeasonalPlayerPosition extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.seasonal-player-position.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'seasonal_player_id' => ['required', Rule::unique('seasonal_player_positions', 'seasonal_player_id'), 'string'],
            'position_id' => ['required', Rule::unique('seasonal_player_positions', 'position_id'), 'string'],
            
        ];
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
