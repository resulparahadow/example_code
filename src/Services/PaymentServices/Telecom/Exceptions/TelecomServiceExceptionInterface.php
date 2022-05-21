<?php

namespace Services\PaymentServices\Telecom\Exceptions;

use \Exception;

interface TelecomServiceExceptionInterface
{
    public function getMessage();
    public function getCode();
    public function getErrorData();

}
