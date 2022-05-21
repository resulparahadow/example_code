<?php

namespace App\Http\Api\V1\Requests\Users\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'phone'=>'required|integer|digits:8'
        ];
    }
}

/**
 * @OA\Schema(
 *     schema="ApiV1AuthLogin",
 *     type="object",
 *     title="ApiV1AuthLogin",
 *     description="Login",
 *     required={"phone"},
 *     @OA\Property(
 *         property="phone",
 *         title="phone",
 *         type="integer",
 *         description="Phone number has to be 8 digit integer number",
 *         example="62007125"
 *     ),
 *  )
 */
