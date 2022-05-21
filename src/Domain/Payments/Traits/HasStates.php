<?php

namespace Domain\Payments\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Domain\Payments\Enums\PaymentState as State;
use Domain\Payments\Enums\PaymentState;

trait HasStates
{
    public static function bootHasStates(): void
    {
        static::creating(function ($model) {
            if (! $model->state) {
                $model->state = State::PENDING;
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
        return PaymentState::keys();
    }
}
