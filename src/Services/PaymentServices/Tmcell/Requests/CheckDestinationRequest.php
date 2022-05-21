<?php

namespace Services\PaymentServices\Tmcell\Requests;

use GuzzleHttp\Client;

class CheckDestinationRequest
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
        return $this->client->request('POST', "{$this->params['username']}/{$this->params['server']}/cd/add",['form_params' => $this->data] );

    }
    public function makeData()
    {
        $data = array_merge($this->args, ['username' => $this->params['username']]);

        $hmac = hash_hmac('sha1', implode(':', $data), base64_decode($this->params['sign_token'], true), true);

        $data = array_merge($data, ['hmac' => base64_encode($hmac)]);

        return $data;
    }

    public function getData()
    {
        return $this->data;
    }
}
