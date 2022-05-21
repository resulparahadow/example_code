<?php

namespace App\Http\Api\V1\Controllers\Users\Payments\Tmcell;

use App\Exceptions\AccountNotFound;
use App\Http\Api\V1\Controllers\Controller;
use App\Http\Api\V1\Requests\Tmcell\CheckDestinationRequest as Request;
use Illuminate\Http\Response;
use Services\ServiceFactory;
use Services\ServicesEnum as Service;

final class CheckDestinationController extends Controller
{
    public function __invoke(Request $request)
    {
        $service = ServiceFactory::make(Service::TMCELL);
        // dd($request->all());
        try {

            $service->setArgs([
                'destination' => $request->phone_number,
                'service' => 'tmcell',
                'ts' => now()->timestamp,
            ]);

            $response = $service->checkDestinition();

            if (!$response->isOk()){
                throw new AccountNotFound($response->getBody());
            }

            return response([
                'success' => true,
                'data'    => [
                    'result' => true
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
*   path="/payments/tmcell/check",
*   tags={"TMCELL"},
*   security={
*      {"bearer_token": {}},
*   },
*   summary="Get payable status of tmcell user",
*   @OA\RequestBody(
*     required=true,
*     @OA\JsonContent(ref="#components/schemas/TmcellCheckDestinationRequest")
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
*            description="request result status"
*         ),
*         @OA\Property(
*            property="data",
*            @OA\Property(
*               property="result",
*               title="result",
*               type="boolean",
*               description="true if phone number can be payed",
*               example="true"
*            )
*         ),
*      ),
*   ),
* )
*/
