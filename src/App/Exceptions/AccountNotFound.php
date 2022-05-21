<?php

namespace App\Exceptions;

use Exception;

class AccountNotFound extends Exception
{
    const TYPE = 'ACCOUNT_NOT_FOUND';
    public $body;
    function __construct($responseBody)
    {
        $this->body = $responseBody;
    }
}
