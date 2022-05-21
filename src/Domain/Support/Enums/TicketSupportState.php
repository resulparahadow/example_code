<?php

namespace Domain\Support\Enums;

use MyCLabs\Enum\Enum;

final class TicketSupportState extends Enum
{
    public const OPENED = 'OPENED';
    public const CLOSED = 'CLOSED';
}
