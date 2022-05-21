<?php

namespace App\Http\Api\V1\Requests\GTS;

use Illuminate\Foundation\Http\FormRequest;

class GetBalanceRequest extends FormRequest
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
            'phone_number' => 'required|numeric|digits:6',
            'type'         => ['required', \Illuminate\Validation\Rule::in(['phone','iptv','inet'])],
            // 'type'         => 'required|min:2|max:5',
        ];
    }
}
/**
 * @OA\Schema(
 *     schema="GTSGetBalanceRequest",
 *     type="object",
 *     title="GTSGetBalanceRequest",
 *     description="gts get balance request body data",
 *     required={"phone_number", "type"},
 *     @OA\Property(
 *         property="phone_number",
 *         title="phone_number",
 *         type="integer",
 *         format="int64",
 *         description="Phone number",
 *         example="274911"
 *     ),
 *     @OA\Property(
 *         property="type",
 *         title="type",
 *         type="string",
 *         description="Type of gts service",
 *         enum={"phone", "inet", "iptv"},
 *         example="inet"
 *     )
 *  )
 */
