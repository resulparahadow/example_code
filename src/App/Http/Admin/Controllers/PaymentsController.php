<?php

namespace App\Http\Admin\Controllers;

use App\Exports\PaymentsExport;
use App\Http\BaseController;
use Domain\BankPayments\Models\BankPayment;
use Domain\Payments\Enums\PaymentState;
use Illuminate\Http\Request;
use Domain\Payments\Models\Payment;
use Maatwebsite\Excel\Facades\Excel;
use Services\ServiceFactory;

class PaymentsController extends BaseController
{
    public function index(Request $r)
    {
        $payments = BankPayment::with('customer')->orderBy('created_at', 'desc')
            // ->adminFilter($r)
            ->paginate();

            // dd($payments);

        return view('admin.payments.index', compact('payments'));
    }

    public function viewPayment(Request $r)
    {
        $payment = BankPayment::where('id', $r->id)
            ->with('transaction')
            ->with('customer')
            ->firstOrFail();

        return view('admin.payments.view', compact('payment'));
    }

    public function retryPayment(Request $r)
    {
        $payment = Payment::where('payments.uuid', $r->uuid)
            ->with('client')
            ->firstOrFail();

        $currBalance = null;

        $payment->dispatchPayableProccess();
        $payment->setState(PaymentState::PENDING);
        return view('admin.payments.view', compact('payment', 'currBalance'));
    }
    public function exportPayment()
    {
        return Excel::download(new PaymentsExport(), 'payments_'.date('Y-m-d H:i').'.xlsx');
    }
}
