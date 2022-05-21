<?php

namespace Domain\Payments\Actions\GTS;

use Domain\BankPayments\Models\BankPayment;
use Services\PaymentServices\ServicesEnum as Service;
use Services\PaymentServices\ServicesTypeEnum as Type;
use Services\PaymentServices\Money\Money;

class CreateGTSPaymentAction
{
    public function execute(BankPayment $bankPayment, array $args, $agreementNumber = null)
    {
        $payment = $bankPayment->payment()->create([
            'action'   => 'App\\Jobs\\GTS\\UpdateBalanceJob',
            'service'  => Service::GTS,
            'type'     => Type::get(Service::GTS, $args['type']),
            'amount'   => $args['money_amount'],
            'destination_number' => $args['phone_number'],
            // 'ref_uuid' => $args['ref_uuid'],
            // 'name'   => $args['name'],
            // 'surname'   => $args['surname'],
            // 'middlename'   => array_key_exists('middlename', $args) ? $args['middlename'] : null,
        ]);

        $payment->setMeta([
            'request' => [
              'type'         => $args['type'],
              'agrm_num'     => $agreementNumber,
              'receipt_num'  => $payment->uuid,
              'receipt_date' => now()->format('Ymdhms'),
              'amount'       => Money::format($args['money_amount']),
            ]
        ]);

        // $payment->dispatchPayableProccess();

        return $payment;
    }


    public function buildAgreementNumber($type, $number)
    {
        return $number;
        return $type == 'phone' ? "{$number}-12" : "{$type}-{$number}";
    }
}
