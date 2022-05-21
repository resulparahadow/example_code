<?php

namespace Domain\Payments\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Domain\Payments\Enums\PaymentState as State;
use Domain\Payments\Enums\PaymentState;

trait HasBankStates
{
    public static function bootHasBankStates(): void
    {
        static::creating(function ($model) {
            if (! $model->state_bank) {
                $model->state_bank = State::PENDING;
            }
        });
    }

    public function setBankState(string $state): void
    {
        $this->state_bank = $state;
        $this->save();
    }
    public static function getBankStatesAsArray()
    {
        return PaymentState::keys();
    }
}
