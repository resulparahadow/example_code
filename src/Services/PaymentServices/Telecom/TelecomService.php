<?php

namespace Services\PaymentServices\Telecom;

use GuzzleHttp\Client as GuzzleClient;
use Services\PaymentServices\Telecom\Requests\CheckRequest;
use Services\PaymentServices\Telecom\Requests\CheckBalanceRequest;
use Services\PaymentServices\Telecom\Requests\PayRequest;
use Services\PaymentServices\ServiceInterface;

class TelecomService implements ServiceInterface
{
    protected $url;
    protected $params;
    protected $args;
    protected $response;
    protected $client;
    protected $environment;
    protected $request;

    public function __construct(array $params, string $environment)
    {
        $this->params = $params;
        $this->url = $params['api_url'];
        $this->environment = $environment;
        $this->client = (new Client($environment, $this->url))->getClient();
    }

    public function setArgs(array $args)
    {
        $this->args = $args;
    }

    public function makePayRequest()
    {
        return $this->request = new PayRequest($this->args, $this->params, $this->client);
    }
    public function makeCheckRequest()
    {
        return $this->request = new CheckRequest($this->args, $this->params, $this->client);
    }
    public function makeCheckBalanceRequest()
    {
        return $this->request = new CheckBalanceRequest($this->args, $this->params, $this->client);
    }

    public function pay()
    {
        $this->makePayRequest();
        $this->response = new Response(
            $this->request->execute()
        );
        return $this->response;
    }

    public function check()
    {
        $this->makeCheckRequest();
        $this->response = new Response(
            $this->request->execute()
        );

        return $this->response;
    }

    public function checkBalance()
    {
        $this->makeCheckBalanceRequest();
        $this->response = new Response(
            $this->request->execute()
        );

        return $this->response;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setArgsByPaymentObj($payment)
    {
        $this->setArgs([
            'account'=> $payment->meta['request']['account'],
            'txn_id'=> now()->timestamp,
            // 'sum'=> $payment->meta['request']['sum'],
            'curr'=> 'TMT',
        ]);
    }
    public function getRequest()
    {
        return $this->request;
    }
}
