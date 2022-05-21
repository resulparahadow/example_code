<?php

namespace Domain\Transactions\Enums;

use MyCLabs\Enum\Enum;

final class TransactionState extends Enum
{
    public const CREATED = 'CREATED';
    public const OK = 'OK';
    public const EXCEPTION = 'EXCEPTION';
}
