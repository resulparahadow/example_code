<?php

namespace App\Http\Web\Controllers\Users\Payments;

use App\Http\Web\Controllers\Controller;
use App\Http\Api\V1\Requests\BankPayment\CheckBankPaymentStatusRequest as Request;
use Domain\BankPayments\Actions\CheckPaymentAction;

class CheckBankPaymentStatusController extends Controller
{
    public function __invoke(Request $request)
    {
        $payment = (new CheckPaymentAction)->execute($request->orderId);

        $payment->payment->dispatchPayableProccess();

        $payment->load('payment', 'user');

        return view('web.payments.checkBankPaymentStatus', compact('payment'));
    }
}
