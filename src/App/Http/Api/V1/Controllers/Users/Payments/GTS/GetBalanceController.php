<?php

namespace App\Http\Api\V1\Controllers\Users\Payments\GTS;

use App\Exceptions\AccountNotFound;
use App\Http\Api\V1\Controllers\Controller;
use App\Http\Api\V1\Requests\GTS\GetBalanceRequest as Request;
use Illuminate\Http\Response;
use Services\ServiceFactory;

class GetBalanceController extends Controller
{
    public function __invoke(Request $request)
    {
        $service = ServiceFactory::make('GTS');

        try {
            $service->setArgs($request->only([
                'type',
                'phone_number'
            ]));

            $response = $service->checkBalance();

            if ($response->hasError()){
                throw new AccountNotFound($response->getBody());
            }

            return response([
                'success' => true,
                'data'    => [
                    'balance'          => $response->getBalance(),
                    'agreement_number' => $response->getAgreementNumber()
                ]
            ]);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            error('UNEXPECTED_EXCEPTION');
        } catch (\GuzzleHttp\Exception\TransferException $e) {
            error('SERVICE_UNAVAILABLE');
        } catch (AccountNotFound $e) {
            error($e::TYPE);
        }
    }
}
/**
* @OA\Get(
*   path="/payments/gts",
*   tags={"GTS"},
*   security={
*      {"bearer_token": {}},
*   },
*   summary="Get balance of gts user",
*   @OA\RequestBody(
*     required=true,
*     @OA\JsonContent(ref="#components/schemas/GTSGetBalanceRequest")
*   ),
*   @OA\Response(
*     response="422",
*     description="Validation error",
*     @OA\JsonContent(ref="#components/schemas/ErrorResponse")
*   ),
*   @OA\Response(
*     response="404",
*     description="Account Not found",
*     @OA\JsonContent(ref="#components/schemas/AccountNotFoundErrorResponse")
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
*         @OA\Property(
*            property="data",
*            @OA\Property(
*               property="balance",
*               title="balance",
*               type="integer",
*               description="balance of gts user",
*               example="11.24"
*            ),
*            @OA\Property(
*               property="agreement_number",
*               title="agreement_number",
*               type="integer",
*               description="agreement_number of this user, you should use this number in top up balance request",
*               example="inet-332233"
*            )
*         ),
*      ),
*   ),
* )
*/
