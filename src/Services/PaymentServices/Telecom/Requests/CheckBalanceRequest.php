<?php

namespace Services\PaymentServices\Telecom\Requests;

use GuzzleHttp\Client;

class CheckBalanceRequest
{
    protected $command = 'check_balance';

    public function execute(
        array $args,
        array $params,
        Client $client
    ) {

        $md5 = md5("{$this->command};{$args['account']};{$args['txn_id']};{$params['secret_key']}");

        $args = array_merge($args, ['command'=>$this->command, 'md5' => $md5]);

        return $client->request('GET', 'tmpochta_kod?', ['query' => $args]);
    }
}
