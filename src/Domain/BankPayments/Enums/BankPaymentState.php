<?php

namespace Domain\BankPayments\Enums;

use MyCLabs\Enum\Enum;

/**
 *  @OA\Schema(
 *    schema="PaymentStateBank",
 *    title="PaymentStateBank",
 *    type="string",
 *    description="Main state of payment",
 *    enum={"STARTED", "PAYED", "REFUNDED", "FAILED"},
 *    example="ORDERED"
 *  )
 */
final class BankPaymentState extends Enum
{
    // payment created
    public const CREATED = 'CREATED';

    public const ORDERED = 'ORDERED';

    public const PAYED = 'PAYED';

    public const REFUNDED = 'REFUNDED';

    public const FAILED = 'FAILED';
}
