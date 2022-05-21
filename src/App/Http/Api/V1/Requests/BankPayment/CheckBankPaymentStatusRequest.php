<?php

namespace App\Http\Api\V1\Requests\BankPayment;

use Illuminate\Foundation\Http\FormRequest;

class CheckBankPaymentStatusRequest extends FormRequest
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
            'orderId'  => 'required',
        ];
    }
}
/**
 * @OA\Schema(
 *     schema="CheckBankPaymentStatusRequest",
 *     type="object",
 *     title="CheckBankPaymentStatusRequest",
 *     description="create telecom payment request body data",
  *     description="Check payment status",
 *     required={"orderId"},
 *     @OA\Property(
 *         property="orderId",
 *         title="orderId",
 *         type="integer",
 *         description="Order Id which is given by server",
 *         example="5a3488f1-49da-4a44-bd6d-e9e029380482"
 *     ),
 *  )
 */
