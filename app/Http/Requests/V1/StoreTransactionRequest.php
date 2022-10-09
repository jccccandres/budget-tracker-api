<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransactionRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'type_id' => ['required', 'exists:types,id'],
            'category_id' => [
                'required', 
                Rule::exists('categories', 'id')
                    ->where('type_id', $this->request->get('typeId'))
            ],
            'note' => ['max:100'],
            'amount' => ['required', 'numeric'],
            'date_transact' => ['required', 'date']
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->userId,
            'type_id' => $this->typeId,
            'category_id' => $this->categoryId,
            'date_transact' => $this->dateTransact
        ]);
    }
}
