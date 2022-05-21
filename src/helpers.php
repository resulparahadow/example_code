<?php

use App\Exceptions\ApplicationException;
use Support\ResponseErrorMessages;
use Illuminate\Support\Str;
use Domain\Clients\Models\Client;
use Illuminate\Http\Request;

function error_if($assert, array $messageBag, array $additional = [], $customMessage = null)
{
    if (!$assert) {
        return;
    }

    error($messageBag, $additional, $customMessage);
}

function error(array $messageBag, array $additional = [], $customMessage = null)
{
    throw new ApplicationException(
        $customMessage ?? $messageBag['message'],
        $messageBag['error'],
        // $messageBag['category'],
        $messageBag['code'],
        $additional,
    );
}

function currentUser()
{
    return request()->user();
}


function currentAdmin()
{
    return auth('admin')->user();
}

function currentClient()
{
    $request = app(Request::class);

    return Client::whereToken($request->bearerToken())->first();
}

function getClassName($object)
{
    $classNameWithNamespace = get_class($object);

    return substr($classNameWithNamespace, strrpos($classNameWithNamespace, '\\')+1);
}

function generateOTP()
{
    $x = 4;
    $min = pow(10, $x);
    $max = pow(10, $x + 1) - 1;
    return rand($min, $max);
}

function strRandom()
{
    return \Str::random(7);
}

function getClientTypes()
{
    return \Domain\Clients\Enums\ClientTypes::toArray();
}

function getPaymentStates()
{
    return \Domain\Payments\Enums\PaymentState::toArray();
}

function getServiceTypes()
{
    return \Services\ServicesTypeEnum::toArray();
}

function getServices()
{
    return \Services\ServicesEnum::toArray();
}

function getQueryStringValue($key){
    $request = app(Request::class);
    return $request->query($key);
}

function isQueryStringExist($key)
{
    return getQueryStringValue($key) ?? false;
}

function doesQueryStringMatch($key, $value)
{
    return getQueryStringValue($key) == $value;
}
function previousQueryStringValue($key, $value)
{
    return isQueryStringExist($key);
}


