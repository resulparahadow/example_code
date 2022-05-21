<?php

namespace Domain\Cards\Models;

use Illuminate\Database\Eloquent\Model;
use Domain\Payments\Models\Payment;
use Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
