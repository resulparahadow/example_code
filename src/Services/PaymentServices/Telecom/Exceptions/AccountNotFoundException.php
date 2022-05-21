<?php

namespace Services\PaymentServices\Telecom\Exceptions;

use \Exception;
use \App\Exceptions\ErrorMessages;
// use PHPUnit\Framework\Constraint\ExceptionMessage;

class AccountNotFoundException extends Exception implements TelecomServiceExceptionInterface
{
    protected $errorData;

    public function __construct()
    {
        $this->errorData = ErrorMessages::SERVICE_PAYMENT_TELECOM_ACCOUNT_NOT_FOUND;
    }

    public function getErrorData(){
        return $this->errorData;
    }

    // public function render($request)
    // {
    //     if (request()->wantsJson()){

    //         return response(['success'=>false, 'msg'=>'accountNotFound'],400);
    //     }
    //     if (request()->wansl)
    // }

}
