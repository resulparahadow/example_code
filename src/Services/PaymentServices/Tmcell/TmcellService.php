<?php

namespace Services\PaymentServices\Tmcell;

use GuzzleHttp\Client as GuzzleClient;
use Services\PaymentServices\Tmcell\Requests\CheckRequest;
use Services\PaymentServices\Tmcell\Requests\AddTransactionRequest;
use Services\PaymentServices\Tmcell\Requests\InfoTransactionRequest;
use Services\PaymentServices\Tmcell\Requests\RetryTransactionRequest;
use Services\PaymentServices\Tmcell\Requests\GetServicesRequest;
use Services\PaymentServices\Tmcell\Requests\GetBalanceRequest;
use Services\PaymentServices\ServiceInterface;
use Services\PaymentServices\Tmcell\Requests\CheckDestinationRequest;

class TmcellService implements ServiceInterface
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

    public function addTransaction() : self
    {
        $this->makeAddTransactionRequest();

        $this->response = new Response(
            $this->request->execute()
        );

        return $this;
    }
    public function makeAddTransactionRequest()
    {
        return $this->request = new AddTransactionRequest($this->args, $this->params, $this->client);
    }

    public function infoTransaction(): self
    {
        $this->makeInfoTransactionRequest();

        $this->response = new Response(
            $this->request->execute()
        );

        return $this;
    }
    public function makeInfoTransactionRequest()
    {
        return $this->request = new InfoTransactionRequest($this->args, $this->params, $this->client);
    }

    public function retryTransaction()
    {
        $this->response = new Response(
            app(RetryTransactionRequest::class)->execute(
                $this->args,
                $this->params,
                $this->client
            )
        );

        return $this->response;
    }

    public function getBalance()
    {
        $this->response = new Response(
            app(GetBalanceRequest::class)->execute(
                $this->args,
                $this->params,
                $this->client
            )
        );

        return $this->response;
    }


    public function getServices()
    {
        $this->response = new Response(
            app(GetServicesRequest::class)->execute(
                $this->args,
                $this->params,
                $this->client
            )
        );

        return $this->response;
    }

    public function checkDestinition(): self
    {
        $this->makeCheckDestinationRequest();
        $this->response = new Response(
            $this->request->execute()
            );
        return $this;
    }
    public function makeCheckDestinationRequest()
    {
        return $this->request = new CheckDestinationRequest($this->args, $this->params, $this->client);
    }

    public function getResponse()
    {
        return $this->response;
    }
    public function setArgsByPaymentObj($payment)
    {
        $this->setArgs([
            'destination'=> $payment->meta['request']['destination'],
            'amount'=> $payment->meta['request']['amount'],
        ]);
    }
}
