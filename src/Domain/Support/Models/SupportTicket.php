<?php

namespace Domain\Support\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Domain\Payments\Models\Payment;
use Domain\Users\Models\User;
use Domain\Support\Enums\TicketSupportState as State;

class SupportTicket extends Model
{
    protected $guarded = [];

    protected $dates = [
        'closed_at',
        'created_at',
        'updated_at'
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'uuid', 'payment_uuid');
    }

    public function openedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'opened_by', 'id');
    }

    public function closedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'closed_by', 'id');
    }

    public static function open(array $data)
    {
        $data = array_merge($data, ['state' => State::OPENED]);

        self::create($data);
    }

    public function close()
    {
        $this->state = State::CLOSED;
        $this->closed_at = now();
        $this->save();
        return $this;
    }
}
