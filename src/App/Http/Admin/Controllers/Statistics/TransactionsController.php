<?php

namespace App\Http\Admin\Controllers\Statistics;

use App\Http\Controller;
use Illuminate\Http\Request;
use Domain\Payments\Models\Payment;
use DB;

class TransactionsController extends Controller
{
    public function main(Request $r)
    {
        return view('admin.transactions.main');
    }
}
