<?php

namespace Domain\Payments\Actions\Tmcell;

use Domain\Payments\Models\Payment;
use Domain\Payments\Enums\PaymentState as State;
use App\Jobs\Tmcell\InfoTransactionJob;

class InfoTmcellTransactionAction
{
    public function execute(Payment $payment)
    {
        try {
            $service = $payment->getPaymentServiceFactory();

            $response = $service->infoTransaction();

            if ($response->isPayed()){
                $payment->setState(State::SUCCESS);
                $payment->captureTransaction(json_encode($response->getBody()), getClassName($this));
                return $payment;
            }

            if ($response->isProcessing()){
                InfoTransactionJob::dispatch($payment)->delay(now()->addSeconds(10));
                return $payment;
            }

            $payment->setState(State::FAILED);
            $payment->captureTransactionError(json_encode($response->getBody()), getClassName($this), 'not payed');

            return $payment;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $payment->setState(State::FAILED);
            $payment->captureTransactionError($e->getResponse()->getBody(), getClassName($this), $e->getMessage());
            // dump($e->getResponse()->getBody(),'info get body, catched');
            return $payment;
        }
    }
}
