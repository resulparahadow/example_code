<?php

namespace Domain\Clients\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Domain\Payments\Models\Payment;

class Client extends Authenticatable
{
    protected $guarded = [];

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
}
