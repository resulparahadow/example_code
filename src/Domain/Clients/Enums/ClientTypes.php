<?php

namespace Domain\Clients\Enums;

use MyCLabs\Enum\Enum;

final class ClientTypes extends Enum
{
    public const SITE = 'SITE';
    public const MOBILE = 'MOBILE';
    public const TERMINAL = 'TERMINAL';
    public const TPOST = 'TPOST';
}
