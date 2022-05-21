<?php

namespace Services\BankPayment\Halkbank\Requests;

use GuzzleHttp\Client;

class CheckPaymentRequest
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
        return $this->client->request('POST', "getOrderStatus.do", ['form_params' => $this->data]);
    }
    public function makeData()
    {
        $data = [
            'userName'    => $this->accountCredential['username'],
            'password'    => $this->accountCredential['password'],
            'orderId'    => $this->args['orderId'],
        ];
        return $data;
    }
    public function getRequestData()
    {
        return $this->data;
    }
}
