<?php

namespace Domain\Payments\Actions\Tmcell;

use App\Jobs\Tmcell\InfoTransactionJob;
use Domain\Payments\Models\Payment;
use Domain\Payments\Enums\PaymentState as State;

class AddTmcellTransactionAction
{
    public function execute(Payment $payment)
    {
        try {
            $service = $payment->getPaymentServiceFactory();

            $response = $service->addTransaction();
            // $payment->setState(State::SUCCESS);
            if ($response->isOk()){
                InfoTransactionJob::dispatch($payment)->delay(now()->addSeconds(10));
                $payment->captureTransaction(json_encode($response->getBody()), getClassName($this));
            } else {
                $payment->setState(State::FAILED);
                $payment->captureTransactionError(json_encode($response->getBody()), getClassName($this), 'something went wrong');
            }

            return $payment;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $payment->setState(State::FAILED);
            $payment->captureTransactionError($e->getResponse()->getBody(), getClassName($this), $e->getMessage());
            return $payment;
        }
    }
}
