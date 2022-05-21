<?php

namespace Domain\Transactions\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Domain\Transactions\Enums\TransactionState as State;

trait HasStates
{
    public static function bootHasStates(): void
    {
        static::creating(function ($model) {
            if (! $model->state) {
                $model->state = State::CREATED;
            }
        });
    }

    public function setState(string $state): void
    {
        $this->state = $state;
        $this->save();
    }

    public function setSubState(string $state): void
    {
        $this->sub_state = $state;
        $this->save();
    }
}
