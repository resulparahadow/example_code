<?php

namespace Domain\Payments\Actions\Telecom;

use Domain\Payments\Models\Payment;
use Domain\Payments\Enums\PaymentState as State;

class PayTelecomAction
{
    public function execute(Payment $payment)
    {
        try {
            $service = $payment->getPaymentServiceFactory();

            $response = $service->pay();

            if ($response->isOk()){
                $payment->setState(State::SUCCESS);
                $payment->captureTransaction(json_encode($response->getBody()), getClassName($this));
                return $payment;
            }

            $payment->setState(State::FAILED);
            $payment->captureTransactionError(json_encode($response->getBody()), getClassName($this), $response->getBody()['comment']);

            return $payment;

        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $payment->setState(State::FAILED);
            $payment->captureTransactionError($e->getResponse()->getBody(), getClassName($this), $e->getMessage());
            return $payment;
        }
    }
}
