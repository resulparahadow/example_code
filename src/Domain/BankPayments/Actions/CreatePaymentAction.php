<?php

namespace Domain\BankPayments\Actions;

use Domain\BankPayments\Enums\BankPaymentState;
use Domain\Users\Models\User;
use Services\BankPayment\BankPaymentTypesEnum;
use Services\PaymentServices\ServicesEnum as Service;
use Services\PaymentServices\ServicesTypeEnum as Type;
use Services\PaymentServices\Money\Money;

class CreatePaymentAction
{
    public function execute(User $user, array $args)
    {
        $bankPayment = $user->bankPayments()->create([
            'amount'   => $args['amount'],
            'type'   => BankPaymentTypesEnum::HALKBANK,
        ]);

        $bankPayment->setMeta([
            'request' => [
                'returnUrl'      => $args['returnUrl'],
                // 'curr'     => 'TMT',
            ],
        ]);

        return $bankPayment;
    }
}
