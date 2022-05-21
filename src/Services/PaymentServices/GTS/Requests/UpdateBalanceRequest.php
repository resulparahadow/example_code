<?php

namespace Services\PaymentServices\GTS\Requests;

use GuzzleHttp\Client;

class UpdateBalanceRequest
{
    protected array $data;
    protected $args;
    protected $client;

    public function __construct(
        array $args,
        Client $client
    ) {
        $this->args = $args;
        $this->client = $client;
        $this->data = $this->makeData();
    }

    public function execute() {
        return $this->client->request('GET', implode('/', $this->data));
    }

    public function makeData()
    {
        $data = [
            'updatebalance/217.174.227.30',
            $this->args['agrm_num'],
            $this->args['receipt_num'],
            $this->args['receipt_date'],
            $this->args['amount'],
        ];

        return $data;
    }
    public function getData()
    {
        return $this->data;
    }
}
