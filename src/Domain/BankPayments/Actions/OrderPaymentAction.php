<?php

namespace Domain\BankPayments\Actions;

use App\Exceptions\ErrorMessages;
use App\Jobs\Tmcell\InfoTransactionJob;
use Domain\BankPayments\Models\BankPayment;
use Domain\Payments\Models\Payment;
use Domain\BankPayments\Enums\BankPaymentState as State;


class OrderPaymentAction
{
    public function execute(BankPayment $payment)
    {
        try {

            $service = $payment->getBankPaymentServiceFactory();

            $response = $service->doOrder(['amount'=>$payment->amount, 'returnUrl'=> $payment->meta['request']['returnUrl']])->getResponse();

            $response->okOrFail();

            $payment->setState(State::ORDERED);

            $payment->setOrderId($response->getOrderId());

            $payment->captureTransaction($response->getBody(), getClassName($this), $service->getRequest()->getRequestData());

            return $response->getBody();

        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $payment->setState(State::FAILED);
            $payment->captureTransactionError($e->getResponse()->getBody(), getClassName($this), $e->getMessage());
            return $payment;
        } catch (\GuzzleHttp\Exception\ConnectException $e){
            $payment->captureTransactionError([], getClassName($this), $e->getMessage());
            error(ErrorMessages::CONNECTION_EXCEPTION);
        } catch (\Services\BankPayment\Halkbank\Exceptions\HalkbankPaymentExceptionInterface $e){
            error($e->getErrorData());
        } catch (\GuzzleHttp\Exception\TransferException $e) {
            $payment->setState(State::FAILED);
            $payment->captureTransactionError([], getClassName($this), $e->getMessage());
            return $payment;
        }
    }
}
