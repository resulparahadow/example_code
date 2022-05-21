<?php

namespace Services\BankPayment\Halkbank\Exceptions;

use \Exception;

interface HalkbankPaymentExceptionInterface
{
    public function getMessage();
    public function getCode();
    public function getErrorData();

}
