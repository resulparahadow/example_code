<?php

namespace Domain\Users\Traits;

trait HasOTP
{
    public static function bootHasOTP(): void
    {
        static::creating(function ($model) {
            if (! $model->verification_code) {
                $model->newOTP();
            }
        });
    }

    public function getOTPName(): string
    {
        return 'verification_code';
    }

    public function generateOTP(): string
    {
        return (string)12345;
    }

    public function newOTP(): string
    {
        $this->verification_code = $this->generateOTP();
        return $this->verification_code;
    }
}
