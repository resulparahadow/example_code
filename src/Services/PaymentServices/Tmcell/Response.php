<?php

namespace Services\PaymentServices\Tmcell;

class Response
{
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

    public function getRawResponse()
    {
        return $this->response->getBody();
    }

    public function parseBody()
    {
        return json_decode($this->response->getBody(), true, 512, JSON_BIGINT_AS_STRING);
    }

    public function getBody()
    {
        return $this->body;
    }

    public function hasError()
    {
        return $this->body['result'] !== 0;
    }

    public function isOk()
    {
        return $this->body['status'] == 'SUCCESS';
    }
    public function isPayed()
    {
        return $this->isOk() && array_key_exists("result",$this->body) && array_key_exists("state",$this->body['result']) && $this->body['result']['state']=='SUCCESS';
    }
    public function isProcessing()
    {
        return $this->isOk() && array_key_exists("result",$this->body) && array_key_exists("state",$this->body['result']) && $this->body['result']['state']=='GW-PROCESSING';
    }
    public function okOrFail()
    {
        return;
    }
}
