<?php

namespace Services\PaymentServices;

use Domain\Payments\Models\Payment;
use Services\Payment\Exceptions\InvalidGatewayException;
use InvalidArgumentException;

class ServiceFactory
{
    public static function make(string $gateway, $environment = 'production')
    {
        $gatewayClass = config('tp_services.gateways')[$gateway]['gateway'];
        $params = config('tp_services.gateways')[$gateway][$environment];

        // Check the Gateway Class exists
        if (! class_exists($gatewayClass)) {
            throw InvalidGatewayException::notFound();
        }

        if (! in_array($environment, ['demo', 'production', 'testing'])) {
            throw new InvalidArgumentException(
                'The environment must be demo or production.'
            );
        }

        return new $gatewayClass($params, $environment);
    }
}
