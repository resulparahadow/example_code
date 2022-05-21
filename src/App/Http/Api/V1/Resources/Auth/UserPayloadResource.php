<?php

namespace App\Http\Api\V1\Resources\Auth;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserPayloadResource extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
