<?php

namespace Services\BankPayment\Halkbank\Exceptions;

use \Exception;
use \App\Exceptions\ErrorMessages;

class OrderIdUsedException extends Exception implements HalkbankPaymentExceptionInterface
{
    protected $errorData;

    public function __construct()
    {
        $this->errorData = ErrorMessages::SERVICE_BANK_PAYMENT_HALKBANK_ORDER_ID_USED_ALREADY;
    }

    public function getErrorData(){
        return $this->errorData;
    }

}
