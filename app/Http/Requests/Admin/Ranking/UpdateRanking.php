<?php

namespace App\Http\Requests\Admin\Ranking;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
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
        return [
            'seasonal_player_id' => ['sometimes', Rule::unique('rankings', 'seasonal_player_id')->ignore($this->ranking->getKey(), $this->ranking->getKeyName()), 'string'],
            'ranking_instance_id' => ['sometimes', Rule::unique('rankings', 'ranking_instance_id')->ignore($this->ranking->getKey(), $this->ranking->getKeyName()), 'string'],
            'rank' => ['sometimes', 'integer'],
            
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
