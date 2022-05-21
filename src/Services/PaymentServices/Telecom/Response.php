<?php

namespace Services\PaymentServices\Telecom;

use Services\PaymentServices\Telecom\Exceptions\AccountNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Response
{
    protected $response;
    protected $body;

    public function __construct($response)
    {
        $this->response = $response;
        $this->body = $this->parseBody();
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getRawResponse()
    {
        return $this->response->getBody();
    }

    public function parseBody()
    {
        $xml = simplexml_load_string($this->response->getBody());
        return json_decode(json_encode($xml), true);
    }

    public function getBody()
    {
        return $this->body;
    }

    // 0 ОК
    // 1 Временная ошибка. Повторите запрос позже
    // 4 Неверный формат идентификатора абонента +
    // 5 Идентификатор абонента не найден (Ошиблись номером) +
    // 7 Прием платежа запрещен провайдером +
    // 8 Прием платежа запрещен по техническим причинам +
    // 10 Неверная цифровая подпись +
    // 40 Валюта договора отличается от валюты платежа +
    // 79 Счет абонента не активен +
    // 90 Проведение платежа не окончено
    // 241 Сумма слишком мала +
    // 242 Сумма слишком велика +
    // 243 Невозможно проверить состояние счета +
    // 300 Другая ошибка провайдера +
    public function hasError()
    {
        return $this->body['result'] !== 0;
    }

    public function isOk()
    {
        return $this->body['result'] == 0;
    }

    public function isAccountNotFound()
    {
        return $this->body['result'] == 0;
    }

    public function getBalance()
    {
        return $this->body['curr_balance'];
    }
    public function okOrFail()
    {
        return;
        if (!$this->isAccountNotFound() ){
            throw new AccountNotFoundException;
        }
        // return $this->body['curr_balance'];
    }
}
