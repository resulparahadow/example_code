<?php

namespace Services\PaymentServices\Money;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money as PHPMoney;

class Money
{
    public static function format($number)
    {
        $money = new PHPMoney($number, new Currency('TMT'));
        $currencies = new ISOCurrencies();

        $moneyFormatter = new DecimalMoneyFormatter($currencies);

        return $moneyFormatter->format($money);
    }
}
