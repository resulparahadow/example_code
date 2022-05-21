<?php

namespace Services\PaymentServices\Tmcell\Requests;

use GuzzleHttp\Client;

class GetServicesRequest
{
    public function execute(
        array $args,
        array $params,
        Client $client
    ) {






        $args = array_merge($args, ['username' => $params['username']]);
// dd(implode(':', $args));
        $hmac = hash_hmac('sha1', implode(':', $args), base64_decode($params['sign_token'], true), true);
// dd(base64_decode($params['sign_token']));
// dd(base64_decode($params['sign_token'], true));
        $args = [
            'ts'   => $args['ts'],
            'hmac' => base64_encode($hmac)
        ];
        // $curl = curl_init();
        // curl_setopt($curl, CURLOPT_URL, 'http://95.85.110.13/api/turkmenpost/server01/dealer/services');
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, 'ts='.$args['ts'].'&hmac='.base64_encode($hmac));
        // $result = curl_exec($curl);
        // curl_close($curl);
        // dd($result);
        // return $client->request('POST', "{$params['username']}/{$params['server']}/dealer/services", $args);
        return $client->request('POST', "{$params['username']}/{$params['server']}/dealer/services",['form_params' => $args] );

    }
}
