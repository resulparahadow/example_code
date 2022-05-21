<?php

namespace App\Exports;

use Domain\Payments\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PaymentsExport implements FromView
{
    public function view(): View
    {
        return view('admin.payments.export_payments', [
            'payments' => Payment::with('client')->orderBy('created_at', 'desc')->adminFilter(request())->get()
        ]);
    }
}
