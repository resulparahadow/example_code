<?php

namespace Domain\Payments\Models;

use Domain\BankPayments\Models\BankPayment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Money\Money;
use Money\Currency;
use Services\ServiceFactory;
use Domain\Payments\Traits\HasStates;
use Domain\Payments\Traits\HasBankStates;
use Domain\Payments\Traits\HasTransactions;
use Domain\Payments\Traits\HasSupport;
use Domain\Payments\Traits\HasScopes;
use Domain\Clients\Models\Client;
use Services\ServicesTypeEnum as Type;

/**
 * @OA\Schema(
 *     schema="PaymentModel",
 *     type="object",
 *     title="PaymentModel",
 *     description="Payment model",
 *     @OA\Property(
 *         property="id",
 *         title="id",
 *         type="integer",
 *         format="int64",
 *         description="The internal ID of this payment",
 *         example="1443"
 *     ),
 *     @OA\Property(
 *         property="uuid",
 *         title="uuid",
 *         type="string",
 *         format="uuid",
 *         description="The internal UUID of this payment",
 *         example="94387003-b27d-4e20-b157-b35079230580"
 *     ),
 *     @OA\Property(
 *         property="ref_uuid",
 *         title="ref_uuid",
 *         type="string",
 *         format="uuid",
 *         description="reference uuid provided by client",
 *         example="94387003-b27d-4e20-b157-b35079230580"
 *     ),
 *     @OA\Property(
 *         property="client_id",
 *         title="client_id",
 *         type="integer",
 *         format="int64",
 *         description="Creator identifier of the payment ",
 *         example="1"
 *     ),
 *     @OA\Property(
 *       property="state",
 *       ref="#/components/schemas/PaymentState"
 *     ),
 *     @OA\Property(
 *       property="method",
 *       ref="#/components/schemas/PaymentMethod"
 *     ),
 *     @OA\Property(
 *       property="service",
 *       ref="#/components/schemas/ServicesEnum"
 *     ),
 *     @OA\Property(
 *       property="type",
 *       ref="#/components/schemas/ServicesTypeEnum"
 *     ),
 *     @OA\Property(
 *         property="amount",
 *         title="Amount",
 *         type="integer",
 *         format="int64",
 *         description="The amount of payment in cents",
 *         example="12000"
 *     ),
 *      @OA\Property(
 *         property="created_at",
 *         title="RFC3339",
 *         type="date-time",
 *         description="Created datetime of payment",
 *         example="2020-05-11T07:35:49.00Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         title="RFC3339",
 *         type="date-time",
 *         description="Updated datetime of payment",
 *         example="2020-05-11T07:35:49.00Z"
 *     ),
 *     @OA\Property(
 *         property="completed_at",
 *         title="RFC3339",
 *         type="date-time",
 *         description="Payment completed date-time",
 *         example="2020-05-11T07:35:49.00Z"
 *     )
 *  )
 */
class Payment extends Model
{
    use SoftDeletes;
    use HasStates;
    use HasBankStates;
    use HasTransactions;
    use HasSupport;
    use HasScopes;

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

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->uuid = Str::orderedUuid()->toString();
            }
        });
    }

    public function getDescriptionAttribute()
    {
        return 'testing api';
    }

    public function getCurrencyAttribute()
    {
        return '934';
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function bankPayments()
    {
        return $this->morphMany(BankPayment::class, 'paymentable');
    }
    public function bankPayment()
    {
        return $this->belongsTo(BankPayment::class, 'bank_payment_id');
    }

    public function getPaymentServiceFactory()
    {
        $class = ServiceFactory::make($this->service);
        $class->setArgs($this->meta['request']);
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

    public function getRequestParam($param)
    {
        return $this->meta['request'][$param] ?? null;
    }

    public function dispatchPayableProccess()
    {
        $this->action::dispatch($this);
    }

    public function isBalanceCheckable()
    {
        return in_array($this->type, Type::balanceCheckableServiceTypes());
    }
}
