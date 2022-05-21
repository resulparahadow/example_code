<?php

namespace Services\BankPayment;

use Services\BankPayment\Halkbank\HalkbankService;

class BankPaymentFactory {

    public function make(string $type = BankPaymentTypesEnum::HALKBANK, $environment='production')
    {
        $params = config('tp_services.gateways')[$type][$environment];
        switch ($type) {
            case BankPaymentTypesEnum::HALKBANK:
                $bankService = new HalkbankService($params, $environment);
                break;

            default:
                # code...
                break;
        }

        return $bankService;
    }
}
