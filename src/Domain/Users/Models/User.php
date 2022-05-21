<?php

namespace Domain\Users\Models;

use Domain\BankPayments\Models\BankPayment;
use Domain\Payments\Models\Payment;
use Domain\Users\Traits\HasOTP;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasOTP;

    protected $fillable = ['phone', 'verification_code', 'is_blocked'];

    public function fullname()
    {
        return "{$this->firstname} {$this->lastname}";
    }
    public function bankPayments()
    {
        return $this->hasMany(BankPayment::class);
    }
}
