<?php

namespace App\Http\Admin\Controllers;

use App\Http\BaseController;
use Illuminate\Http\Request;
use Domain\Payments\Models\Payment;
use Domain\Payments\Enums\PaymentState as State;
use Domain\Transactions\Enums\TransactionState;
use Domain\Transactions\Models\Transaction;
use Domain\Clients\Models\Client;
use DB;

class DashboardController extends BaseController
{
    public function index(Request $r)
    {
        return view('admin.dashboard.index');
    }

    public function getTotalAmount()
    {
        $total = Payment::select([DB::raw("SUM(amount) as total_amount")])
            ->today()
            ->whereState(State::SUCCESS)
            ->groupBy('amount')
            ->first();

        return $total ? $total->total_amount : null;
    }

    public function getSuccessPayments()
    {
        $payments = Payment::whereState(State::SUCCESS)
        ->today()
        ->count();

        return $payments;
    }

    public function getFailedPayments()
    {
        $payments = Payment::whereState(State::FAILED)
        ->today()
        ->count();

        return $payments;
    }

    public function getClientsCount()
    {
        $clients = Client::count();

        return $clients;
    }

    public function getPaymentsGroupedByService()
    {
        $total = Payment::select([
            DB::raw("service as service"),
            DB::raw("COUNT(service) as count"),
            DB::raw("SUM(amount) as sum")
        ])
        ->whereState(State::SUCCESS)
        ->groupBy('service')
        ->today()
        ->get();

        return $total;
    }
}
