<?php

namespace Services\PaymentServices\GTS\Requests;

use GuzzleHttp\Client;

class GetBalanceRequest
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
            'getbalance/217.174.227.30',
            $this->buildPhoneNumber($this->args['type'], $this->args['phone_number']),
        ];

        return $data;
    }
    public function getData()
    {
        return $this->data;
    }

    public function buildPhoneNumber($type, $number)
    {
        return $type == 'phone' ? "{$number}-12" : "{$type}-{$number}";
    }

}
