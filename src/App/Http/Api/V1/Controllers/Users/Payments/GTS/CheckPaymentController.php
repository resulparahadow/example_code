<?php

namespace App\Http\Api\V1\Controllers\Users\Payments\GTS;

use App\Http\Api\V1\Controllers\Controller;
use App\Http\Api\V1\Requests\GTS\CheckPaymentRequest as Request;
use Domain\BankPayments\Actions\CheckPaymentAction;

class CheckPaymentController extends Controller
{
    public function __invoke(Request $request)
    {
        // dd($request->orderId);
        $payment = (new CheckPaymentAction)->execute($request->orderId);

        $payment->payment->dispatchPayableProccess();

        return $this->response([
            'ok',
        ]);
    }
}
/**
* @OA\Get(
*   path="/payments/gts-check-payment",
*   tags={"GTS"},
*   security={
*      {"bearer_token": {}},
*   },
*   summary="Check telecom payment status",
*   @OA\RequestBody(
*     required=true,
*     @OA\JsonContent(ref="#components/schemas/GTSCheckPaymentRequest")
*   ),
*   @OA\Response(
*     response="422",
*     description="Validation error",
*     @OA\JsonContent(ref="#components/schemas/ErrorResponse")
*   ),
*   @OA\Response(
*     response="200",
*     description="result",
*     @OA\JsonContent(
*         @OA\Property(
*            property="success",
*            title="status",
*            type="boolean",
*            description="result status"
*         ),
*     ),
*   ),
* )
*/
