<?php

namespace App\Http\Api\V1\Controllers\Users\Payments\Tmcell;

use App\Http\Api\V1\Controllers\Controller;
use App\Http\Api\V1\Requests\Tmcell\CheckPaymentRequest as Request;
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
*   path="/payments/tmcell-check-payment",
*   tags={"TMCELL"},
*   security={
*      {"bearer_token": {}},
*   },
*   summary="Create a new telecom payment",
*   @OA\RequestBody(
*     required=true,
*     @OA\JsonContent(ref="#components/schemas/TmcellPaymentCheckRequest")
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
