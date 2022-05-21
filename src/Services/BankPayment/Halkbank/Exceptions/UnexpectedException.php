<?php

namespace Services\BankPayment\Halkbank\Exceptions;

use \Exception;
use \App\Exceptions\ErrorMessages;

class UnexpectedException extends Exception implements HalkbankPaymentExceptionInterface
{
    protected $errorData;

    public function __construct()
    {
        $this->errorData = ErrorMessages::SERVICE_BANK_PAYMENT_HALKBANK_UNEXPECTED_ERROR;
    }

    public function getErrorData(){
        return $this->errorData;
    }

}
