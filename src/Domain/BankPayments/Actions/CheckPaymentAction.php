<?php

namespace Domain\BankPayments\Actions;

use Domain\BankPayments\Models\BankPayment;
use Domain\BankPayments\Enums\BankPaymentState as State;


class CheckPaymentAction
{
    public function execute($orderId)
    {
        try {
            $payment = BankPayment::whereOrderId($orderId)->firstOrFail();

            $service = $payment->getBankPaymentServiceFactory();

            $response = $service->checkPayment(['orderId'=>$orderId])->getResponse();

            $response->paidOrFail();

            $payment->setState(State::PAYED);

            $payment->captureTransaction($response->getBody(), getClassName($this), $service->getRequest()->getRequestData());

            return $payment;

        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $payment->captureTransactionError($e->getResponse()->getBody(), getClassName($this), $e->getMessage());
            return $payment;
        } catch (\GuzzleHttp\Exception\TransferException $e) {
            $payment->captureTransactionError([], getClassName($this), $e->getMessage());
            return $payment;
        }
    }
}
