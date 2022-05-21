<?php

namespace Domain\Payments\Enums;

use MyCLabs\Enum\Enum;

/**
 *  @OA\Schema(
 *    schema="PaymentState",
 *    title="PaymentState",
 *    type="string",
 *    description="Main state of payment",
 *    enum={"CREATED", "PENDING", "SUCCESS", "FAILED"},
 *    example="ORDERED"
 *  )
 */
final class PaymentState extends Enum
{
    // payment created
    public const CREATED = 'CREATED';

    // payment proccess is going
    public const PENDING = 'PENDING';

    // if payable process is successfully completed
    public const SUCCESS = 'SUCCESS';

    // else
    public const FAILED = 'FAILED';
}
