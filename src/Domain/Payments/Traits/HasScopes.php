<?php

namespace Domain\Payments\Traits;

use Services\ServicesTypeEnum as Type;

trait HasScopes
{

    public function scopeToday($q)
    {
        return $q->whereRaw('Date(created_at) = CURDATE()');
    }

    public function scopeBalanceCheckable($q)
    {
        $balanceCheckableServiceTypes = TYPE::balanceCheckableServiceTypes();
        return $q->whereIn('type', $balanceCheckableServiceTypes);
    }

    public function scopeClientType($q, $type)
    {
        $q->whereHas('client', function($qClient)use ($type){
            return $qClient->where('type', $type);
        });
    }

    public function scopeAdminFilter($q, $r)
    {
        return $q
        ->when($r->name, fn ($q, $v) => $q->where('name', 'like', '%'.$v.'%'))
        ->when($r->surname, fn ($q, $v) => $q->where('surname', 'like', '%'.$v.'%'))
        ->when($r->destination_number, fn ($q, $v) => $q->where('destination_number', 'like', '%'.$v.'%'))
        ->when($r->service, fn ($q, $v) => $q->whereService($v))
        ->when($r->type, fn ($q, $v) => $q->whereType($v))
        ->when($r->state, fn ($q, $v) => $q->whereState($v))
        ->when($r->min_date, fn ($q, $v) => $q->where('created_at', '>=', $v))
        ->when($r->max_date, fn ($q, $v) => $q->where('created_at', '<=', $v))
        ->when($r->amount, fn ($q, $v) => $q->whereAmount($v))
        ->when($r->client, fn ($q, $v) => $q->clientType($v))
        ->when($r->search, fn ($q, $v) => $q->whereAny($v));
    }

    public function scopeWhereAny($q, $i)
    {
        // return $q
        // ->where('name', 'like', '%'.$i.'%');
        return $q
        ->where('name', 'like', '%'.$i.'%')
        ->orWhere('surname', 'like', '%'.$i.'%')
        ->orWhere('middlename', 'like', '%'.$i.'%')
        ->orWhere('destination_number', 'like', '%'.$i.'%')
        ->orWhere('service',$i)
        ->orWhere('type',$i)
        ->orWhere('amount',$i)
        ;
    }
}
