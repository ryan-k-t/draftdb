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
            'player_id' => ['required', Rule::unique('seasonal_player', 'player_id')->ignore($this->seasonalPlayer->getKey(), $this->seasonalPlayer->getKeyName()), 'integer'],
            'season' => ['required', Rule::unique('seasonal_player', 'season')->ignore($this->seasonalPlayer->getKey(), $this->seasonalPlayer->getKeyName()), 'integer'],
            'school' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'classification_id' => ['required', 'integer'],
            'commitment' => ['nullable', 'string'],
            'height' => ['nullable', 'integer'],
            'weight' => ['nullable', 'integer'],
            'bats' => ['required', 'integer'],
            'throws' => ['required', 'integer'],
            
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
