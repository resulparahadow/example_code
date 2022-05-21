<?php

namespace App\Http\Api\V1\Requests\Tmcell;

use Illuminate\Foundation\Http\FormRequest;

class CheckRequest extends FormRequest
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
            'money_amount'  => 'required|numeric|min:1|max:100000',
            'account'       => 'required|numeric|digits:6'
        ];
    }
}
