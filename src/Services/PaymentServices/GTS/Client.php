<?php

namespace Services\PaymentServices\GTS;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class Client
{
    protected $baseUrl;
    protected $environment;

    public function __construct(string $environment, $url)
    {
        $this->environment = $environment;
        $this->baseUrl = $url;
    }

    public function getClient()
    {
        return call_user_func(array($this, $this->environment));
    }

    public function production()
    {
        return new GuzzleClient([
            'base_uri' => $this->baseUrl,
            'defaults' => [
                'exception' => false
            ],
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'curl' => [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ]
        ]);
    }

    public function testing()
    {
        $mock = new MockHandler([
            // new Response(200, ['X-Foo' => 'Bar'], json_encode(['result' => 'action_success', 'receipt' => '1831581'])),
            // new Response(402, ['X-Foo' => 'Bar'], json_encode(['result' => 'wrong_payment_number'])),
            new Response(200, ['X-Foo' => 'Bar'], json_encode(['result' => 'action_success', 'number' => '1831581', 'balance' => '0.2'])),
            new RequestException('Error Communicating with Server', new Request('GET', 'test'))
        ]);

        $handlerStack = HandlerStack::create($mock);

        return new GuzzleClient([
            'base_uri' => $this->baseUrl,
            'handler'  => $handlerStack,
            'defaults' => [
                'exception' => false,
            ],
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }
}
