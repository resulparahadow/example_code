<?php

namespace App\Jobs\Tmcell;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Domain\Payments\Actions\Tmcell\InfoTmcellTransactionAction;
use Domain\Payments\Models\Payment;

class InfoTransactionJob implements ShouldQueue
{
    use SerializesModels;
    use Queueable;
    use Dispatchable;
    use InteractsWithQueue;

    public $tries = 3;

    public $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function handle()
    {
        (new InfoTmcellTransactionAction())->execute(
            $this->payment
        );
    }
}
