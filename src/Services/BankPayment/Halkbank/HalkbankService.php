<?php

namespace Services\BankPayment\Halkbank;

use Services\BankPayment\BankPaymentInterface;
use Services\BankPayment\Halkbank\Requests\CheckPaymentRequest;
use Services\BankPayment\Halkbank\Requests\OrderRequest;
use Services\BankPayment\Halkbank\Requests\RefundPaymentRequest;
use Services\BankPayment\Halkbank\Responses\CheckPaymentResponse;
use Services\BankPayment\Halkbank\Responses\OrderResponse;
use Services\BankPayment\Halkbank\Responses\RefundPaymentResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HalkbankService implements BankPaymentInterface {

    protected $args;
    protected $params;
    protected $client;
    protected $action = 'notStarted';
    protected $request;
    protected $response;
    protected array $accountCredentials = [];
    protected $password;
    protected $url = 'https://mpi.gov.tm/payment/rest/';

    function __construct(array $params, $environment)
    {
        $this->params = $params;
        $this->accountCredentials = $params['credentials']['default_account'];
        $this->client = (new Client($environment, $this->url))->getClient();
    }

    public function doOrder($args)
    {
        $this->makeOrderRequest($args);
        $this->action = 'payRequest';
        $this->response = new OrderResponse(
            $this->request->execute()
        );
        return $this;
    }
    protected function makeOrderRequest($args)
    {
        $this->request = new OrderRequest($args, $this->params, $this->accountCredentials, $this->client);
    }

    public function checkPayment($args)
    {
        $this->makeCheckPaymentRequest($args);
        $this->action = 'checkPaymentRequest';
        $this->response = new CheckPaymentResponse(
            $this->request->execute()
        );
        return $this;
    }
    protected function makeCheckPaymentRequest($args)
    {
        $this->request = new CheckPaymentRequest($args, $this->params, $this->accountCredentials, $this->client);
    }

    // To use refund action, make sure Your merchant account has refund permission!!!
    public function refundPayment($args)
    {
        $this->makeRefundPaymentRequest($args);
        $this->action = 'refundPaymentRequest';
        $this->response = new RefundPaymentResponse(
            $this->request->execute()
        );
        return $this;
    }
    protected function makerefundPaymentRequest($args)
    {
        $this->request = new RefundPaymentRequest($args, $this->params, $this->accountCredentials, $this->client);
    }
    public function getResponse()
    {
        return $this->response;
    }
    public function getRequest()
    {
        return $this->request;
    }
    public function getAction()
    {
        return $this->action;
    }
    public function setAccountCredentials(array $accountCredential)
    {
        $this->accountCredentials = $accountCredential;
    }
}
