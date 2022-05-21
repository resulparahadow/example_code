<?php

namespace Support;

use Illuminate\Http\Response;

class ResponseErrorMessages
{
    // common
    public const UNEXPECTED_EXCEPTION = [
        'error'    => 'UNEXPECTED_EXCEPTION',
        'message'  => 'unexpected exception',
        'code'     =>  Response::HTTP_INTERNAL_SERVER_ERROR
    ];

    public const SERVICE_UNAVAILABLE = [
        'error'    => 'SERVICE_UNAVAILABLE',
        'message'  => 'error',
        'code'     =>  Response::HTTP_INTERNAL_SERVER_ERROR
    ];

    public const MODEL_NOT_FOUND = [
        'error'    => 'MODEL_NOT_FOUND',
        'message'  => 'model not found',
        'code'     =>  Response::HTTP_NOT_FOUND
    ];

    public const INVALID_PAYMENT_STATE = [
        'error'    => 'INVALID_PAYMENT_STATE',
        'message'  => 'Unacceptable state of payment',
        'code'     =>  Response::HTTP_FORBIDDEN
    ];

    public const PAYMENT_FAILED = [
        'error'    => 'PAYMENT_FAILED',
        'message'  => 'payment proccess fail',
        'code'     =>  Response::HTTP_INTERNAL_SERVER_ERROR
    ];

    public const NO_RESULT = [
        'error'    => 'NO_RESULT',
        'message'  => 'No result',
        'code'     =>  Response::HTTP_NOT_FOUND
    ];

    // auth
    public const USER_NOT_FOUND = [
        'error'    => 'USER_NOT_FOUND',
        'message'  => 'User not found',
        'code'     =>  Response::HTTP_NOT_FOUND
    ];

    public const ALREADY_EXISTS = [
        'error'    => 'ALREADY_EXISTS',
        'message'  => 'resource already exists',
        'code'     =>  Response::HTTP_CONFLICT
    ];

    public const USER_IS_BLOCKED = [
        'error'    => 'USER_IS_BLOCKED',
        'message'  => 'User is blocked by administrator',
        'code'     =>  Response::HTTP_FORBIDDEN
    ];

    public const INVALID_OTP = [
        'error'    => 'INVALID_OTP',
        'message'  => 'invalid otp',
        'code'     =>  Response::HTTP_UNPROCESSABLE_ENTITY
    ];

    public const UNAUTHORIZED_ACTION = [
        'error'    => 'UNAUTHORIZED_ACTION',
        'message'  => 'unauthorized action',
        'code'     =>  Response::HTTP_UNAUTHORIZED
    ];

    public const MISSING_SCOPE = [
        'error'    => 'MISSING_SCOPE',
        'message'  => 'Missing required scope for this action',
        'code'     =>  Response::HTTP_FORBIDDEN
    ];

    public const TOKEN_EXPIRED = [
        'error'    => 'TOKEN_EXPIRED',
        'message'  => 'token expired',
        'code'     =>  Response::HTTP_UNAUTHORIZED
    ];

    public const OTP_EXPIRED = [
        'error'    => 'OTP_EXPIRED',
        'message'  => 'otp expired',
        'code'     =>  Response::HTTP_UNAUTHORIZED
    ];

    public const ACCOUNT_NOT_FOUND = [
        'error'    => 'ACCOUNT_NOT_FOUND',
        'message'  => 'this account not found',
        'code'     =>  Response::HTTP_NOT_FOUND
    ];
}
