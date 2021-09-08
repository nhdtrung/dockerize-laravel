<?php

namespace App\Http\Requests\Wager;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\WagerException;

class BuyRequest extends FormRequest
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
            'buying_price' => 'required|numeric|gt:0',
        ];
    }

    /**
     * @throws WagerException
     */
    protected function failedValidation(Validator $validator) {
        throw new WagerException($validator);
    }
}
