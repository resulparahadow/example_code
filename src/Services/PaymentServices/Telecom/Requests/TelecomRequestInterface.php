<?php

namespace Services\PaymentServices\Telecom\Requests;

interface TelecomRequestInterface
{
    public function execute();
    public function makeData();
    public function getData();
}
