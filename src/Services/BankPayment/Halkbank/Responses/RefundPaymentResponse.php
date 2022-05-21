<?php

namespace Services\BankPayment\Halkbank\Responses;

class RefundPaymentResponse implements HalkbankResponseInterface
{
    const ERRORS = [
        0 => 'No system error',
        5 => 'Erroneous value of a request parameter.',
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
        return $this->body['errorCode'] == 0;
    }
    public function getError()
    {
        return self::ERRORS[$this->body['errorCode']] ?? 'some unknown error';
    }

    public function okOrFail()
    {
        return $this->isOk();
    }
}
