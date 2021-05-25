<?php

namespace App\Http\Requests\Admin\RankingInstance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateRankingInstance extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.ranking-instance.edit', $this->rankingInstance);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'source' => ['required'],
            'season' => ['required'],
            'date' => ['required', 'date'],
            'description' => ['string']
            
        ];
    }

    public function getSourceId(){
        if ($this->has('source')){
            return $this->get('source')['id'];
        }
        return null;
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
