<?php

namespace Services\PaymentServices\Tmcell;

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
            'debug'    => false,
            'base_uri' => $this->baseUrl,
            'defaults' => [
                'exception' => false,
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
            new Response(200, ['X-Foo' => 'Bar'], $this->testCheckXmlResponse()),
            new Response(200, ['X-Foo' => 'Bar'], $this->testPayXmlResponse()),
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

    public function testPayXmlResponse()
    {
        return <<<XML
        <?xml version="1.0" encoding="UTF-8"?>
        <response>
            <osmp_txn_id>1233333</osmp_txn_id>
            <prv_txn>33333333</prv_txn>
            <sum>4.20</sum>
            <result>0</result>
            <comment></comment>
        </response>
        XML;
    }

    public function testCheckXmlResponse()
    {
        return <<<XML
        <?xml version="1.0" encoding="UTF-8"?>
        <response>
            <osmp_txn_id>1233333</osmp_txn_id>
            <result>0</result>
            <comment></comment>
        </response>
        XML;
    }
}
