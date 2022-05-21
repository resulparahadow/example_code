<?php

namespace App\Http\Api\V1\Controllers\Users\Payments;

use App\Http\Api\V1\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FetchController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = currentUser();

        $payment = $user->bankPayments()->where('id', $request->payment_id)->firstOrFail();

        return response([
            'success' => true,
            'data'    => [
                'state'=> $payment->state
            ]
        ]);
    }
}
/**
* @OA\Get(
*   path="/client/payment/{payment_id}",
*   tags={"Payments"},
*   security={
*      {"bearer_token": {}},
*   },
*   summary="Fetch a payment by payment_id",
*   @OA\Parameter(
*     name="payment_id",
*     in="query",
*     description="id of the payment",
*     required=true,
*     @OA\Schema(
*      type="integer",
*     )
*   ),
*   @OA\Response(
*     response="404",
*     description="MODEL_NOT_FOUND",
*     @OA\JsonContent(ref="#components/schemas/ModelNotFoundErrorResponse")
*   ),
*   @OA\Response(
*      response="200",
*      description="ok",
*      @OA\JsonContent(
*         @OA\Property(
*           property="success",
*           title="status",
*           type="boolean",
*           description="result status"
*          ),
*         @OA\Property(
*            property="data",
*            @OA\Property(
*            property="state",
*            ref="#components/schemas/PaymentStateBank"),
*            )
*         )
*       )
*   ),
* )
*/
