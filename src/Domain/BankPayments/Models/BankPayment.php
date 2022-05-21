<?php

namespace Domain\BankPayments\Models;

use Domain\BankPayments\Traits\HasStates;
use Domain\BankPayments\Traits\HasTransactions;
use Domain\Payments\Models\Payment;
use Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Services\BankPayment\BankPaymentFactory;

class BankPayment extends Model
{
    use SoftDeletes;
    use HasStates;
    use HasTransactions;

    protected $guarded = [];

    protected $casts = [
        'meta'  => 'json',
        'items' => 'json'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'completed_at'
    ];
    public function paymentable()
    {
        return $this->morphTo();
    }
    public function payment()
    {
        return $this->hasOne(Payment::class, 'bank_payment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getBankPaymentServiceFactory()
    {
        $class = (new BankPaymentFactory())->make($this->type);
        // $class->setArgs($this->meta['request']);
        return $class;
    }
    public function getMeta()
    {
        return $this->meta;
    }

    public function setMeta($meta)
    {
        $this->meta = $meta;
        $this->save();
    }

    public function setOrderId($orderId)
    {
        $this->order_id = $orderId;
        $this->save();
    }
}
