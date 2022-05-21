<?php

namespace App\Http\Admin\Controllers;

use App\Http\BaseController;
use Illuminate\Http\Request;
use Domain\Transactions\Models\Transaction;

class TransactionsController extends BaseController
{
    public function index(Request $r)
    {
        $transactions = Transaction::orderBy('created_at', 'desc')
                        ->when($r->state, fn ($q, $v) => $q->whereState($v))
                        // ->when($r->payment_uuid, fn ($q, $uuid) => $q->wherePaymentUuid($uuid))
                        ->orderBy('order')
                        ->with('bankPayment')
                        ->paginate();

        return view('admin.transactions.index', compact('transactions'));
    }

    public function viewTransaction(Request $r)
    {
        $transaction = Transaction::where('id', $r->id)
                        ->with('bankPayment')
                        ->firstOrFail();

        return view('admin.transactions.view', compact('transaction'));
    }
}
