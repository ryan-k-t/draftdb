<?php

namespace App\Http\Requests\Admin\SeasonalPlayerPosition;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateSeasonalPlayerPosition extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.seasonal-player-position.edit', $this->seasonalPlayerPosition);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'seasonal_player_id' => ['sometimes', Rule::unique('seasonal_player_positions', 'seasonal_player_id')->ignore($this->seasonalPlayerPosition->getKey(), $this->seasonalPlayerPosition->getKeyName()), 'string'],
            'position_id' => ['sometimes', Rule::unique('seasonal_player_positions', 'position_id')->ignore($this->seasonalPlayerPosition->getKey(), $this->seasonalPlayerPosition->getKeyName()), 'string'],
            
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
