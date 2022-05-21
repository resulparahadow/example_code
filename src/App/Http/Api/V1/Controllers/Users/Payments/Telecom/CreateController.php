<?php

namespace App\Http\Api\V1\Controllers\Users\Payments\Telecom;

use App\Http\Api\V1\Controllers\Controller;
use App\Http\Api\V1\Requests\Telecom\CreateRequest as Request;
use Domain\Payments\Actions\Telecom\CreateTelecomPaymentAction as Action;
use Domain\BankPayments\Actions\CreatePaymentAction as BankCreatePaymentAction;
use Domain\BankPayments\Actions\OrderPaymentAction as BankOrderPaymentAction;
use Services\PaymentServices\ServiceFactory;
use Services\PaymentServices\ServicesEnum as Service;
use Services\PaymentServices\Telecom\Exceptions\TelecomServiceExceptionInterface;
use Illuminate\Support\Facades\DB;

class CreateController extends Controller
{
    public function __invoke(Request $request, ServiceFactory $service)
    {
        try {
            DB::beginTransaction();

            // when testing below line should be present
            $request->merge(['money_amount' => 1]);

            $user = currentUser();

            $service = $service::make(Service::TELECOM);

            $service->setArgs([
                'account'  => $request->phone_number,
            ]);

            $response = $service->check();

            $response->okOrFail();

            $bankPayment = app(BankCreatePaymentAction::class)->execute($user, ['amount'=>$request->money_amount, 'returnUrl'=>route('api.v1.telecom.checkPayment')]);

            $payment = app(Action::class)->execute($bankPayment, $request->all());

            $responseBody = app(BankOrderPaymentAction::class)->execute($bankPayment);

            DB::commit();

            return $this->response([
                'formUrl'  => $responseBody['formUrl'],
            ]);
        } catch (TelecomServiceExceptionInterface $e){
            DB::rollBack();
            error($e->getErrorData());
        }
    }
}
/**
* @OA\Post(
*   path="/payments/telecom",
*   tags={"TELECOM"},
*   security={
*      {"bearer_token": {}},
*   },
*   summary="Create a new telecom payment",
*   @OA\RequestBody(
*     required=true,
*     @OA\JsonContent(ref="#components/schemas/TelecomPaymentCreateRequest")
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
