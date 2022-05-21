<?php

namespace Services\PaymentServices\Tmcell\Exceptions;

use \Exception;

interface TmcellServiceExceptionInterface
{
    public function getMessage();
    public function getCode();
    public function getErrorData();

}
