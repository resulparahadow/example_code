<?php

namespace App\Http\Api\V1\Requests\Telecom;

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
            'account'       => 'required|numeric|digits:8'
        ];
    }
}/**
 * @OA\Schema(
 *     schema="TelecomCheckRequest",
 *     type="object",
 *     title="TelecomCheckRequest",
 *     description="Telecom check request body data",
 *     required={"money_amount", "account"},
 *     @OA\Property(
 *         property="money_amount",
 *         title="money_amount",
 *         type="integer",
 *         description="Amount of money, 120 is 1.20 manat",
 *         example="100"
 *     ),
 *     @OA\Property(
 *         property="account",
 *         title="account",
 *         type="integer",
 *         format="int64",
 *         description="account number to check",
 *         example="12274911"
 *     )
 *  )
 */
