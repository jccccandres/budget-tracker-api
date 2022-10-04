<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'type_id' => ['required', 'exists:types,id'],
            'user_id' => ['required', 'exists:users,id'],
            'description' => [
                'required',
                Rule::unique('categories', 'description')->where(
                    fn ($query) => $query
                        ->where('user_id', $this->request->get('userId'))
                        ->where('type_id', $this->request->get('typeId'))
                )
            ]
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'type_id' => $this->typeId,
            'user_id' => $this->userId
        ]);
    }
}
