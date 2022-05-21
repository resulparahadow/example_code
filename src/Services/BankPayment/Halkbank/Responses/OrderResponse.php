<?php

namespace Services\BankPayment\Halkbank\Responses;

use Services\BankPayment\Halkbank\Exceptions\UnexpectedException;

class OrderResponse implements HalkbankResponseInterface
{
    const ERRORS = [
        0 => 'No system error.',
        1 => 'Order number is duplicated, order with given order number is processed already',
        3 => 'Unknown currency',
        4 => 'Mandatory request parameter was not specified',
        5 => 'Erroneous value of a request parameter.',
        7 => 'System error.',
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
    public function getOrderId()
    {
        return $this->body['orderId'];
    }
    public function getFormUrl()
    {
        return $this->body['formUrl'];
    }
    public function getError()
    {
        return self::ERRORS[$this->body['errorCode']] ?? 'some unknown error';
    }

    public function okOrFail()
    {
        if ($this->isOk()){
            return true;
        }
        throw new UnexpectedException;
    }
}
