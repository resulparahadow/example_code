<?php

namespace App\Http\Api\V1\Requests\Tmcell;

use Illuminate\Foundation\Http\FormRequest;

class CheckDestinationRequest extends FormRequest
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
            'phone_number'  => 'required|numeric',
            // 'service'       => 'required|numeric|digits:6'
        ];
    }
}
/**
 * @OA\Schema(
 *     schema="TmcellCheckDestinationRequest",
 *     type="object",
 *     title="TmcellCheckDestinationRequest",
 *     description="check destination tmcell payment request body data",
 *     required={"phone_number"},
 *     @OA\Property(
 *         property="phone_number",
 *         title="phone_number",
 *         type="integer",
 *         format="int64",
 *         description="Destination phone number",
 *         example="62615986"
 *     ),
 *  )
 */
