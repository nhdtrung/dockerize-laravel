<?php

namespace App\Http\Requests\Wager;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\WagerException;

class StoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'total_wager_value' => 'required|integer|gt:0',
            'odds' => 'required|integer|gt:0',
            'selling_percentage' => 'required|integer|between:1,100',
            'selling_price' => 'required|gt:0|regex:/^\d+(\.\d{1,2})?$/',
        ];
    }

    /**
     * @throws WagerException
     */
    protected function failedValidation(Validator $validator) {
        throw new WagerException($validator);
    }
}
