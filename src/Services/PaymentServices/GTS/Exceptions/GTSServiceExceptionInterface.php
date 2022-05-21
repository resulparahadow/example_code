<?php

namespace Services\PaymentServices\GTS\Exceptions;

use \Exception;

interface GTSServiceExceptionInterface
{
    public function getMessage();
    public function getCode();
    public function getErrorData();
}
