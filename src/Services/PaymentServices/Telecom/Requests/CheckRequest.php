<?php

namespace Services\PaymentServices\Telecom\Requests;

use GuzzleHttp\Client;

class CheckRequest implements TelecomRequestInterface
{
    protected $command = 'check';
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

    public function execute()
    {
        return $this->client->request('GET', 'tmpochta_kod?', ['query' => $this->data]);
    }
    public function makeData()
    {
        $txnId = now()->timestamp;
        $md5 = md5("{$this->command};{$this->args['account']};{$txnId};{$this->params['secret_key']}");

        $data = array_merge($this->args, ['command'=>$this->command, 'md5' => $md5]);

        return $data;
    }
    public function getData()
    {
        return $this->data;
    }
}
