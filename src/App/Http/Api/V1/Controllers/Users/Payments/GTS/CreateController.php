<?php

namespace App\Http\Api\V1\Controllers\Users\Payments\GTS;

use App\Http\Api\V1\Controllers\Controller;
use App\Http\Api\V1\Requests\GTS\CreateRequest as Request;
use Domain\Payments\Actions\GTS\CreateGTSPaymentAction as Action;
use Domain\BankPayments\Actions\CreatePaymentAction as BankCreatePaymentAction;
use Domain\BankPayments\Actions\OrderPaymentAction as BankOrderPaymentAction;
use Services\PaymentServices\ServiceFactory;
use Services\PaymentServices\ServicesEnum as Service;
use Illuminate\Support\Facades\DB;
use Services\PaymentServices\GTS\Exceptions\GTSServiceExceptionInterface;

class CreateController extends Controller
{
    public function __invoke(Request $request, ServiceFactory $service)
    {
        try {
            DB::beginTransaction();

            // when testing below line should be present
            $request->merge(['money_amount' => 1]);

            $user = currentUser();

            $service = $service::make(Service::GTS);

            $service->setArgs([
                'type'  => $request->type,
                'phone_number'  => $request->phone_number,
            ]);
            $response = $service->checkBalance()->getResponse();

            $response->okOrFail();

            $agreementNumber = $response->getAgreementNumber();

            $bankPayment = app(BankCreatePaymentAction::class)->execute($user, ['amount'=>$request->money_amount, 'returnUrl'=>route('api.v1.telecom.checkPayment')]);

            $payment = app(Action::class)->execute($bankPayment, $request->all(), $agreementNumber);

            $responseBody = app(BankOrderPaymentAction::class)->execute($bankPayment);

            DB::commit();

            return $this->response([
                'formUrl'  => $responseBody['formUrl'],
            ]);
        } catch (GTSServiceExceptionInterface $e){
            DB::rollBack();
            error($e->getErrorData());
        }
    }
}
/**
* @OA\Post(
*   path="/payments/gts",
*   tags={"GTS"},
*   security={
*      {"bearer_token": {}},
*   },
*   summary="Create a new GTS payment",
*   @OA\RequestBody(
*     required=true,
*     @OA\JsonContent(ref="#components/schemas/GTSPaymentCreateRequest")
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
*         @OA\Property(
*            property="data",
*            @OA\Property(
*               property="formUrl",
*               title="Form Url",
*               type="string",
*               description="Form Url for payment gateway",
*               example="https://mpi.gov.tm/payment/merchants/online/payment_ru.html?mdOrder=5a3488f-121-1212-12"
*            )
*         ),
*     ),
*   ),
* )
*/
