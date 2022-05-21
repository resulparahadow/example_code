<?php

namespace Domain\Payments\Actions\Tmcell;

use Domain\BankPayments\Models\BankPayment;
use Domain\Clients\Models\Client;
use Services\PaymentServices\ServicesEnum as Service;
use Services\PaymentServices\ServicesTypeEnum as Type;

class CreateTmcellPaymentAction
{
    public function execute(BankPayment $bankPayment, array $args)
    {
        $payment = $bankPayment->payment()->create([
            'action'   => 'App\\Jobs\\Tmcell\\AddTransactionJob',
            'service'  => Service::TMCELL,
            'type'     => Type::get(Service::TMCELL, 'PHONE'),
            'amount'   => $args['money_amount'],
            'destination_number' => $args['phone_number'],
            // 'ref_uuid' => $args['ref_uuid'],
            // 'name'   => $args['name'],
            // 'surname'   => $args['surname'],
            // 'middlename'   => array_key_exists('middlename', $args) ? $args['middlename'] : null,
        ]);

        $payment->setMeta([
            'request' => [
                'local-id'    => config('tp_services.gateways.TMCELL.testing.local_id_prefix').$payment->id,
                'service'     => 'tmcell',
                'amount'      => $args['money_amount'],
                'destination' => $args['phone_number'],
                'txn-ts'      => now()->addDay()->timestamp,
                'ts'          => now()->timestamp,
                // 'hmac'        => hmac with access token
            ],
        ]);


        $payment->dispatchPayableProccess();

        return $payment;
    }
}
