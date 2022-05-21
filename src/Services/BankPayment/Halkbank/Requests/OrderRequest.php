<?php

namespace Services\BankPayment\Halkbank\Requests;

use GuzzleHttp\Client;

class OrderRequest
{
    protected array $data;
    protected $args;
    protected $params;
    protected $client;
    protected array $accountCredential;

    public function __construct(
        array $args,
        array $params,
        array $accountCredential,
        Client $client
    ) {
        $this->args = $args;
        $this->params = $params;
        $this->client = $client;
        $this->accountCredential = $accountCredential;
        $this->data = $this->makeData();
    }
    public function execute() {
        return $this->client->request('POST', "register.do", ['form_params' => $this->data]);
    }
    public function makeData()
    {
        $data = [
            'userName'    => $this->accountCredential['username'],
            'password'    => $this->accountCredential['password'],
            'pageView'    => $this->args['pageView'] ?? 'DESKTOP',
            'description' => $this->args['description'] ?? 'payment',
            'orderNumber' => $this->args['orderNumber'] ?? uniqid(),
            'amount'      => $this->args['amount'],
            'currency'    => $this->args['currency'] ?? '934',
            'language'    => $this->args['language'] ?? 'ru',
            'returnUrl'   => $this->args['returnUrl'],
            'failUrl'     => $this->args['failUrl'] ?? $this->args['returnUrl'],
            'sessionTimeoutSecs' => $this->args['sessionTimeoutSecs'] ?? 600,
        ];
        return $data;
    }
    public function getRequestData()
    {
        return $this->data;
    }
}
