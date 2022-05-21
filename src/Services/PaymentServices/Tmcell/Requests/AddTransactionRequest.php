<?php

namespace Services\PaymentServices\Tmcell\Requests;

use GuzzleHttp\Client;

class AddTransactionRequest
{
    protected array $data;
    protected $args;
    protected $params;
    protected $client;

    public function __construct(
        array $args,
        array $params,
        Client $client
    ) {
        $this->args = $args;
        $this->params = $params;
        $this->client = $client;
        $this->data = $this->makeData();
    }
    public function execute() {
        return $this->client->request('POST', "{$this->params['username']}/{$this->params['server']}/txn/add", ['form_params' => $this->data]);
    }

    public function makeData()
    {
        $data = [
            'local-id'=> $this->args['local-id'],
            'service'=> $this->args['service'],
            'amount'=> $this->args['amount'],
            'destination'=> $this->args['destination'],
            'txn-ts' => now()->addDay()->timestamp,
            'ts' => now()->timestamp,
            'username' => $this->params['username'],
        ];

        $hmac = hash_hmac('sha1', implode(':', $data), base64_decode($data['sign_token'], true), true);

        $data = array_merge($data, ['hmac' => base64_encode($hmac)]);

        return $data;
    }

    public function getData()
    {
        return $this->data;
    }
}
