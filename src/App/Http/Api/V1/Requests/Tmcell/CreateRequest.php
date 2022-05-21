<?php

namespace App\Http\Api\V1\Requests\Tmcell;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'money_amount'  => 'required|numeric',
            'phone_number'  => 'required|numeric|digits_between:8,11',
        ];
    }
}
/**
 * @OA\Schema(
 *     schema="TmcellPaymentCreateRequest",
 *     type="object",
 *     title="TmcellPaymentCreateRequest",
 *     description="create tmcell payment request body data",
 *     required={"money_amount", "phone_number"},
 *     @OA\Property(
 *         property="money_amount",
 *         title="money_amount",
 *         type="integer",
 *         description="Amount of money, 120 is 1.20 manat",
 *         example="100"
 *     ),
 *     @OA\Property(
 *         property="phone_number",
 *         title="phone_number",
 *         type="integer",
 *         format="int64",
 *         description="Destination phone_number number",
 *         example="12461699"
 *     ),
 *  )
 */
