<?php

namespace Domain\Payments\Actions\GTS;

use Domain\Payments\Models\Payment;
use Domain\Payments\Enums\PaymentState as State;

class UpdateBalanceAction
{
    public function execute(Payment $payment)
    {
        try {
            $service = $payment->getPaymentServiceFactory();

            $response = $service->updateBalance();

            if (!$response->hasError()){
                $payment->setState(State::SUCCESS);
                $payment->captureTransaction($response->getBody(), getClassName($this));
            } else {
                $payment->setState(State::FAILED);
                $payment->captureTransactionError($response->getBody(), getClassName($this), $response->getError());
            }

            return $payment;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $payment->setState(State::FAILED);

            $payment->captureTransactionError(
                $e->getResponse()->getBody(),
                getClassName($this),
                $e->getMessage()
            );

            return $payment;
        }
    }
}
