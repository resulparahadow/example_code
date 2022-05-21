<?php

namespace Services\PaymentServices\Telecom\Requests;

use GuzzleHttp\Client;

class PayRequest implements TelecomRequestInterface
{
    protected $command = 'pay';
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
        return $this->client->request('GET', 'tmpochta_kod', ['query' => $this->data]);
    }

    public function makeData()
    {
        $data = [
            'command' => $this->command,
            'account'  => $this->args['account'],
            'txn_id'   => now()->timestamp,
            'txn_date' => now()->format('Ymdhms'),
            'sum'      => $this->args['sum'],
            'curr'     => $this->args['curr'],
        ];

        $md5 = md5("{$this->command};{$this->args['account']};{$this->args['txn_id']};{$this->params['secret_key']}");

        $data['md5'] = $md5;

        return $data;
    }

    public function getData()
    {
        return $this->data;
    }
}
