<?php

namespace App\Http\Api\V1\Requests\Users\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
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
            'phone'=>'required',
            'otp'=>'required',
        ];
    }
}

/**
 * @OA\Schema(
 *     schema="ApiV1AuthVerifyOtp",
 *     type="object",
 *     title="ApiV1AuthVerifyOtp",
 *     description="Login",
 *     required={"phone"},
 *     @OA\Property(
 *         property="phone",
 *         title="phone",
 *         type="integer",
 *         description="Phone number has to be 8 digit integer number",
 *         example="62007125"
 *     ),
 *     @OA\Property(
 *         property="otp",
 *         title="otp",
 *         type="integer",
 *         description="otp number was recieved from server",
 *         example="62007125"
 *     ),
 *  )
 */
