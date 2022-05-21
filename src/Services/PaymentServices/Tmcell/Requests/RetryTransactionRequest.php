<?php

namespace Services\PaymentServices\Tmcell\Requests;

use GuzzleHttp\Client;

class RetryTransactionRequest
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
        return $this->client->request('POST', "{$this->params['username']}/{$this->params['server']}/txn/retry", $this->data);
    }

    public function makeData()
    {
        $data = array_merge($this->args, ['username' => $this->params['username']]);

        $hmac = hash_hmac('sha1', implode(':', $data), base64_decode($this->params['sign_token'], true), true);

        $data = [
            'local-id' => $data['local-id'],
            'ts'       => $data['ts'],
            'hmac'     => base64_encode($hmac)
        ];

        return $data;
    }

    public function getData()
    {
        return $this->data;
    }

}
