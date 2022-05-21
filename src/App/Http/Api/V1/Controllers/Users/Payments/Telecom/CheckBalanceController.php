<?php

namespace App\Http\Api\V1\Controllers\Users\Payments\Telecom;

use App\Http\Api\V1\Controllers\Controller;
use App\Http\Api\V1\Requests\Telecom\CheckBalanceRequest as Request;
use Illuminate\Http\Response;
use Services\ServiceFactory;
use Services\ServicesEnum as Service;

class CheckBalanceController extends Controller
{
    public function checkBalance(Request $request)
    {
        $service = ServiceFactory::make(Service::TELECOM);

        try {
            $service->setArgs([
                    'command'  => 'check_balance',
                    'txn_id'   => now()->timestamp,
                    'account'  => $request->account,
                    'curr'     => 'TMT',
                ]);

            $response = $service->checkBalance();

            return response([
                    'success' => $response->isOk() ? true : false,
                    'data'    => [
                        'result' => $response->isOk() ? $this->getBalance() : false,
                    ]
                ]);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            error('UNEXPECTED_EXCEPTION');
        } catch (\GuzzleHttp\Exception\TransferException $e) {
            error('SERVICE_UNAVAILABLE');
        }
    }
}
