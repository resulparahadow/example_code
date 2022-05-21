<?php

namespace App\Exceptions;
use Illuminate\Http\Response;
use MyCLabs\Enum\Enum;

class ErrorMessages extends Enum
{
    const SERVICE_PAYMENT_TELECOM_ACCOUNT_NOT_FOUND = [
        'error'     => 'ACCOUNT_NOT_FOUND',
        'message'   => 'SERVICE_PAYMENT_TELECOM_ACCOUNT_NOT_FOUND',
        'code'      => Response::HTTP_BAD_REQUEST,
    ];

    const SERVICE_BANK_PAYMENT_HALKBANK_UNEXPECTED_ERROR = [
        'error'     => 'UNEXPECTED_ERROR',
        'message'   => 'SERVICE_BANK_PAYMENT_HALKBANK_UNEXPECTED_ERROR',
        'code'      => Response::HTTP_INTERNAL_SERVER_ERROR,
    ];

    const SERVICE_BANK_PAYMENT_HALKBANK_ORDER_ID_USED_ALREADY = [
        'error'     => 'ORDER_ID_USED_ALREADY',
        'message'   => 'SERVICE_BANK_PAYMENT_HALKBANK_ORDER_ID_USED_ALREADY',
        'code'      => Response::HTTP_INTERNAL_SERVER_ERROR,
    ];

    const CONNECTION_EXCEPTION = [
        'error'     => 'CONNECTION_EXCEPTION',
        'message'   => 'CONNECTION_EXCEPTION',
        'code'      => Response::HTTP_INTERNAL_SERVER_ERROR,
    ];

    const INTERNAL_SERVER_ERROR = [
        'error'     => 'UNEXPECTED_EXCEPTION',
        'message'   => 'unexpected exception',
        'code'      => Response::HTTP_INTERNAL_SERVER_ERROR,
        'category'  => 'server'
    ];

    const MODEL_NOT_FOUND = [
        'error'     => 'MODEL_NOT_FOUND',
        'message'   => 'Model not found',
        'code'      => Response::HTTP_NOT_FOUND,
        'category'  => 'server'
    ];

    // AUTH
    const USER_NOT_FOUND = [
        'error'     => 'USER_NOT_FOUND',
        'message'   => 'User not found in db',
        'code'      => Response::HTTP_NOT_ACCEPTABLE,
        'category'  => 'auth'
    ];

    const USER_BLOCKED = [
        'error'     => 'USER_BLOCKED',
        'message'   => 'User is blocked',
        'code'      => Response::HTTP_NOT_ACCEPTABLE,
        'category'  => 'auth'
    ];

    const INVALID_OTP = [
        'error'     => 'INVALID_OTP',
        'message'   => 'invalid one time password',
        'code'      => Response::HTTP_NOT_ACCEPTABLE,
        'category'  => 'auth'
    ];

    const PHONE_NOT_UNIQUE = [
        'error'     => 'PHONE_NOT_UNIQUE',
        'message'   => 'User phone already exists',
        'code'      => Response::HTTP_NOT_ACCEPTABLE,
        'category'  => 'auth'
    ];


    // CART AND STOCK
    const NOT_ENOUGH_STOCK = [
        'error'     => 'NOT_ENOUGH_STOCK',
        'message'   => 'Not enough stock in warehouse',
        'code'      => Response::HTTP_NOT_ACCEPTABLE,
        'category'  => 'stock'
    ];

    const MISSING_STOCK = [
        'error'     => 'MISSING_STOCK',
        'message'   => 'missing stock record',
        'code'      => Response::HTTP_NOT_ACCEPTABLE,
        'category'  => 'stock'
    ];

    const CART_LINE_ID_MISMATCH = [
        'error'     => 'CART_LINE_ID_MISMATCH',
        'message'   => 'cart line not exists',
        'code'      => Response::HTTP_NOT_ACCEPTABLE,
        'category'  => 'cart'
    ];

    const CART_ALREADY_COMPLETED = [
        'error'     => 'CART_ALREADY_COMPLETED',
        'message'   => 'Cart already completed',
        'code'      => Response::HTTP_NOT_ACCEPTABLE,
        'category'  => 'cart'
    ];

    const CART_EMPTY = [
        'error'     => 'CART_EMPTY',
        'message'   => 'no items added to cart',
        'code'      => Response::HTTP_NOT_ACCEPTABLE,
        'category'  => 'cart'
    ];

}
