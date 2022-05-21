<?php

namespace Domain\Payments\Traits;

use Domain\ClientSupport\Models\SupportTicket as Ticket;
use Domain\ClientSupport\Enums\SupportTicketState as State;

trait HasSupport
{
    public static function bootHasSupport(): void
    {
        static::creating(function ($model) {
            if (! $model->state) {
                $model->state = State::OPENED;
            }
        });
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'uuid', 'payment_uuid');
    }

    public function openSupportTicket()
    {
        $this->tickets()
            ->create([
                'opened_by' => currentAdmin()->id
            ]);
    }
}
