<?php

namespace App\Exceptions;

use Exception;

class ApplicationException extends Exception
{
    /**
    * @var @string
    */
    public $error;

    /**
    * @var @string
    */
    public $message;

    /**
    * @var @string
    */
    public $translatedMessage;

    /**
    * @var @mixed
    */
    public $data;

    /**
    * @var @int
    */
    public $code;

    public function __construct(string $message, string $error, int $code = 0, array $data = null)
    {
        parent::__construct($message, $code);

        $this->error = $error;
        $this->message = $message;
        $this->translatedMessage = trans('exception.'.$message);
        $this->code = $code;
        $this->data = $data;
    }

    public function render($request)
    {
        if (request()->wantsJson()){
            return response([
                'success'=>false,
                'data'=> [
                    'error' => $this->error,
                    'message' => $this->translatedMessage,
                ],
            ], $this->code);
        }
    }
}
