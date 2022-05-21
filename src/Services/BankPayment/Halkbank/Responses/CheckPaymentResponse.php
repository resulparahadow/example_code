<?php

namespace Services\BankPayment\Halkbank\Responses;

class CheckPaymentResponse implements HalkbankResponseInterface
{
    const ERRORS = [
        0 => 'No system error',
        2 => 'The order is declined because of an error in the payment credentials.',
        5 => 'Access denied or The user must change his password or [orderId] is empty',
        6 => 'Unregistered OrderId',
        7 => 'System error',
    ];
    protected $response;
    protected $body;

    public function __construct($response)
    {
        $this->response = $response;
        $this->body = $this->parseBody();
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function parseBody()
    {
        return json_decode($this->response->getBody(), true, 512, JSON_BIGINT_AS_STRING);
    }

    public function getBody()
    {
        return $this->body;
    }

    public function isOk()
    {
        return $this->body['ErrorCode'] == 0;
    }
    public function isPayed()
    {
        return $this->body['OrderStatus'] == 2;
    }
    public function isRefunded()
    {
        return $this->body['OrderStatus'] == 4;
    }
    public function getError()
    {
        return self::ERRORS[$this->body['errorCode']] ?? 'some unknown error';
    }

    public function okOrFail()
    {
        if ($this->isOk()){
            return;
        }
        // throw error;
    }

    public function paidOrFail()
    {
        $this->okOrFail();
        if ($this->isPayed()){
            return;
        }
        // throw error;
    }
}
