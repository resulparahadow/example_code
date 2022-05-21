<?php

namespace Services\PaymentServices\GTS;

use GuzzleHttp\Client as GuzzleClient;
use Services\PaymentServices\GTS\Requests\UpdateBalanceRequest;
use Services\PaymentServices\GTS\Requests\GetBalanceRequest;
use Services\PaymentServices\ServiceInterface;

class GTSService implements ServiceInterface
{
    protected $url;
    protected $params;
    protected $args;
    protected $response;
    protected $request;
    protected $client;
    protected $environment;

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

    public function updateBalance()
    {
        $this->makeUpdateBalanceRequest();

        $this->response = new Response(
            $this->request->execute()
        );

        return $this;
    }
    public function makeUpdateBalanceRequest()
    {
        return $this->request = new UpdateBalanceRequest($this->args, $this->client);
    }

    public function checkBalance()
    {
        $this->makeCheckBalanceRequest();
        $this->response = new Response(
            $this->request->execute()
        );
        return $this;
    }
    public function makeCheckBalanceRequest()
    {
        return $this->request = new GetBalanceRequest($this->args, $this->client);
    }

    public function getResponse()
    {
        return $this->response;
    }
    public function setArgsByPaymentObj($payment)
    {
        $this->setArgs([
            'type' => $payment->meta['request']['type'],
            'phone_number' => $payment->destination_number,
            'agreement_number'=> $payment->meta['request']['agrm_num'],
            'amount'=> $payment->meta['request']['amount'],
        ]);
    }
}
