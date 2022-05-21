<?php

namespace App\Http\Api\V1\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PaginatorLinks",
 *     type="object",
 *     title="PaginatorLinks",
 *     description="Pagination links",
 *     @OA\Property(
 *         property="first",
 *         type="string",
 *         description="first page",
 *         example="http://tmpay.loc/api/v1/payments?page=1"
 *     ),
 *     @OA\Property(
 *         property="last",
 *         type="string",
 *         description="from",
 *         example="http://tmpay.loc/api/v1/payments?page=10"
 *     ),
 *     @OA\Property(
 *         property="prev",
 *         type="string",
 *         description="prev page",
 *         example="http://tmpay.loc/api/v1/payments?page=2"
 *     ),
 *     @OA\Property(
 *         property="next",
 *         type="string",
 *         description="next page",
 *         example="http://tmpay.loc/api/v1/payments?page=1"
 *     )
 *  )
 */


/**
 * @OA\Schema(
 *     schema="PaginatorMeta",
 *     type="object",
 *     title="PaginatorMeta",
 *     description="Pagination meta data",
 *     @OA\Property(
 *         property="current_page",
 *         type="integer",
 *         description="current page",
 *         example="2"
 *     ),
 *     @OA\Property(
 *         property="from",
 *         type="integer",
 *         description="from",
 *         example="1"
 *     ),
 *     @OA\Property(
 *         property="last_page",
 *         type="integer",
 *         description="last page",
 *         example="10"
 *     ),
 *     @OA\Property(
 *         property="per_page",
 *         type="integer",
 *         description="Per page",
 *         example="10"
 *     ),
 *     @OA\Property(
 *         property="to",
 *         type="integer",
 *         description="Per page",
 *         example="10"
 *     ),
 *     @OA\Property(
 *         property="total",
 *         type="integer",
 *         description="Total page",
 *         example="10"
 *     ),
 *  )
 */
class PaginatorCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // dd($request);
        return [
            'id' => $this->id,
            'state' => $this->state,
            'service' => $this->payment->service,
            'service_type' => $this->payment->type,
            'amount' => $this->amount,
        ];
        return parent::toArray($request);
    }
}
