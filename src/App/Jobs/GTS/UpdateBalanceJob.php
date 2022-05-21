<?php

namespace App\Jobs\GTS;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Domain\Payments\Actions\GTS\UpdateBalanceAction;
use Domain\Payments\Models\Payment;

class UpdateBalanceJob implements ShouldQueue
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
        (new UpdateBalanceAction())->execute(
            $this->payment
        );
    }
}
