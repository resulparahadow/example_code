<?php

namespace App\Http\Admin\Controllers\Statistics;

use App\Http\Controller;
use Illuminate\Http\Request;
use Domain\Payments\Models\Payment;
use Services\ServicesEnum as Services;
use DB;

class PaymentsController extends Controller
{
    public function main(Request $r)
    {
        $month = $r->month ?? now()->format('m');
        $year = $r->year ?? now()->format('Y');
        $service = $r->service ?? 'GTS';

        $payments = Payment::select([
            DB::raw("service as service"),
            DB::raw("COUNT(service) as count"),
            DB::raw("SUM(amount) as sum"),
            DB::raw("DAY(created_at) as day")
        ])
        ->whereRaw('MONTH(created_at) = ?', [$month])
        ->whereRaw('YEAR(created_at) = ?', [$year])
        ->whereService($service)
        ->groupBy('service', 'day')
        ->get();

        $types = Services::toArray();

        return view('admin.statistics.payments.main', compact('payments', 'types'));
    }
}
