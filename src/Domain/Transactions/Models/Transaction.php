<?php

namespace Domain\Transactions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Domain\Payments\Models\Payment;
use Domain\Clients\Models\Client;

class Transaction extends Model
{
    protected $guarded = [];

    protected $casts = [
        'meta' => 'json',
        'request' => 'json',
        'response' => 'json'
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'uuid', 'payment_uuid');
    }

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function scopeToday($q)
    {
        return $q->whereRaw('Date(created_at) = CURDATE()');
    }
}
