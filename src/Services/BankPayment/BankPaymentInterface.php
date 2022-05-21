<?php

namespace Services\BankPayment;

interface BankPaymentInterface {
    public function doOrder($args);
    public function checkPayment($args);
}
