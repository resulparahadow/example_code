<?php

namespace Services\PaymentServices;

use MyCLabs\Enum\Enum;

/**
 *  @OA\Schema(
 *    schema="ServicesTypeEnum",
 *    title="ServicesTypeEnum",
 *    type="string",
 *    description="Service subtypes",
 *    enum={"GTS_INET", "GTS_PHONE", "GTS_IPTV", "TELC_INET", "TMCELL_PHONE"},
 *    example="GTS_INET"
 *  )
 */
final class ServicesTypeEnum extends Enum
{
    // GTS
    public const GTS_INET = 'GTS_INET';
    public const GTS_PHONE = 'GTS_PHONE';
    public const GTS_IPTV = 'GTS_IPTV';

    // TELEKOM
    public const TELECOM_INET = 'TELC_INET';

    // TMCELL
    public const TMCELL_PHONE = 'TMCELL_PHONE';

    public static function get($service, $type)
    {
        $type = strtoupper($type);

        $v = "{$service}_{$type}";

        return self::$v();
    }
    public static function balanceCheckableServiceTypes()
    {
        return [self::TELECOM_INET, self::GTS_INET, self::GTS_IPTV, self::GTS_PHONE];
    }
}
