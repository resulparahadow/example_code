<?php

namespace Services\PaymentServices;

use MyCLabs\Enum\Enum;

/**
 *  @OA\Schema(
 *    schema="ServicesEnum",
 *    title="ServicesEnum",
 *    type="string",
 *    description="Service types",
 *    enum={"GTS", "TELECOM", "TMCELL"},
 *    example="GTS"
 *  )
 */
final class ServicesEnum extends Enum
{
    // public const PYGG = 'PYGG';
    public const GTS = 'GTS';
    public const TELECOM = 'TELECOM';
    public const TMCELL = 'TMCELL';
}
