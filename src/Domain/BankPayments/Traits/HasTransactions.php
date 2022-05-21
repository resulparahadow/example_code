<?php

namespace Domain\BankPayments\Traits;

use Domain\Transactions\Models\Transaction;
use Domain\Transactions\Enums\TransactionState;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasTransactions
{
    public $latestTransaction;

    public function transaction(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    public function captureTransaction($response, string $name, $request = null)
    {
        $this->loadLatestTransaction();

        return $this
                ->transaction()
                ->create([
                    'previous_id'  => $this->getLatestTransactionId(),
                    'order'        => $this->getLatestTransactionOrder(),
                    // 'client_id'    => $this->client_id,
                    'service'      => $this->type,
                    'request'      => $request,
                    'response'     => $response,
                    'state'        => TransactionState::OK,
                    'name'         => $name
                ]);
    }

    public function captureTransactionError($response, string $name, $error = null)
    {
        $this->loadLatestTransaction();

        return $this
                ->transaction()
                ->create([
                    'previous_id' => $this->getLatestTransactionId(),
                    'order'       => $this->getLatestTransactionOrder(),
                    // 'client_id'   => $this->client_id,
                    'service'     => $this->type,
                    'response'    => $response,
                    'exception'   => $error,
                    'state'       => TransactionState::EXCEPTION,
                    'name'        => $name
                ]);
    }

    public function getLatestTransaction()
    {
        return $this->transaction()
                ->orderBy('order', 'desc')
                ->first();
    }

    public function getLatestTransactionOrder()
    {
        return isset($this->latestTransaction->order) ? $this->latestTransaction->order + 1 : 1;
    }

    public function getLatestTransactionId()
    {
        return $this->latestTransaction->id ?? null;
    }

    public function loadLatestTransaction()
    {
        $this->latestTransaction = $this->getLatestTransaction();
    }
}
