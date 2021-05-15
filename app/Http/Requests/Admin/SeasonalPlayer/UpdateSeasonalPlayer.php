<?php

namespace App\Http\Requests\Admin\SeasonalPlayer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateSeasonalPlayer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.seasonal-player.edit', $this->seasonalPlayer);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'player_id' => ['sometimes', Rule::unique('seasonal_player', 'player_id')->ignore($this->seasonalPlayer->getKey(), $this->seasonalPlayer->getKeyName()), 'string'],
            'season' => ['sometimes', Rule::unique('seasonal_player', 'season')->ignore($this->seasonalPlayer->getKey(), $this->seasonalPlayer->getKeyName()), 'date'],
            'school' => ['nullable', 'string'],
            'city' => ['sometimes', 'string'],
            'state' => ['sometimes', 'string'],
            'classification_id' => ['sometimes', 'string'],
            'commitment' => ['nullable', 'string'],
            'height' => ['nullable', 'integer'],
            'weight' => ['nullable', 'integer'],
            'bats' => ['sometimes', 'string'],
            'throws' => ['sometimes', 'string'],
            
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
