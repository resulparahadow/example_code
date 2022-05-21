<?php

namespace Domain\BankPayments\Traits;

use Domain\BankPayments\Enums\BankPaymentState as State;
use Domain\BankPayments\Enums\BankPaymentState;

trait HasStates
{
    public static function bootHasStates(): void
    {
        static::creating(function ($model) {
            if (! $model->bank_state) {
                $model->state = State::CREATED;
            }
        });
    }

    public function setState(string $state): void
    {
        $this->state = $state;
        $this->save();
    }
    public static function getStatesAsArray()
    {
        return BankPaymentState::keys();
    }
}
