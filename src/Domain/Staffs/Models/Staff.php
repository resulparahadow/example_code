<?php

namespace Domain\Staffs\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    protected $table = 'staffs';

    public function fullname()
    {
        return "{$this->firstname} {$this->lastname}";
    }
}
