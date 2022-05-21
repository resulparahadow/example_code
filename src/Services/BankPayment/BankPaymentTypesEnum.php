<?php

namespace Services\BankPayment;

use MyCLabs\Enum\Enum;

/**
 *  @OA\Schema(
 *    schema="BankTypesEnum",
 *    title="BankTypesEnum",
 *    type="string",
 *    description="Bank Types types",
 *    enum={"HALKBANK", "VNESKA"},
 *    example="HALKBANK"
 *  )
 */
final class BankPaymentTypesEnum extends Enum
{
    public const HALKBANK = 'HALKBANK';
    public const VNESKA = 'VNESKA';
}
