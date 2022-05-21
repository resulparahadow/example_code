<?php

namespace Domain\Payments\Actions\Telecom;

use Domain\BankPayments\Models\BankPayment;
use Domain\Users\Models\User;
use Services\PaymentServices\ServicesEnum as Service;
use Services\PaymentServices\ServicesTypeEnum as Type;
use Services\PaymentServices\Money\Money;

class CreateTelecomPaymentAction
{
    public function execute(BankPayment $bankPayment, array $args)
    {
        $payment = $bankPayment->payment()->create([
            'action'   => 'App\\Jobs\\Telecom\\PayTelecomJob',
            'service'  => Service::TELECOM,
            'type'     => Type::get(Service::TELECOM, 'INET'),
            // 'ref_uuid' => $args['ref_uuid'],
            'amount'   => $args['money_amount'],
            // 'name'   => $args['name'],
            // 'surname'   => $args['surname'],
            // 'middlename'   =>array_key_exists('middlename', $args) ? $args['middlename']:null,
            'destination_number' => $args['phone_number'],
        ]);

        $payment->setMeta([
            'request' => [
                // 'command'  => 'pay',
                // 'txn_id'   => $payment->id,
                // 'txn_date' => now()->format('Ymdhms'),
                'account'  => $args['phone_number'],
                'sum'      => Money::format($args['money_amount']),
                'curr'     => 'TMT',
            ],
        ]);

        // $payment->dispatchPayableProccess();

        return $payment;
    }
}
