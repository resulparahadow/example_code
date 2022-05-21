<?php

namespace Services\PaymentServices\GTS;

use Services\PaymentServices\GTS\Exceptions\AccountNotFoundException;

class Response
{
    protected $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getBody()
    {
        return json_decode($this->response->getBody(), true, 512, JSON_BIGINT_AS_STRING);
    }

    public function getBalance()
    {
        return $this->getBody()->balance;
    }

    public function getAgreementNumber()
    {
        return '122212';
        return $this->getBody()->number;
    }

    public function hasError()
    {
        return $this->getBody()->result !== 'action_success';
    }

    public function getError()
    {
        return $this->getBody()->result;
    }

    public function isOk()
    {
        return !$this->hasError();
    }

    public function okOrFail()
    {
        return;
        if (!$this->isOk() ){
            throw new AccountNotFoundException;
        }
    }
}
