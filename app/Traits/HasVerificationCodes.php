<?php
namespace App\Traits;
// app/Traits/GeneratesVerificationCodes.php

use App\Models\Verification_code;;
use Illuminate\Support\Str;

trait HasVerificationCodes
{
    /**
     * Generate a verification code for the model
     */
    public function generateVerificationCode(string $codeType, int $expiryHours = 24): Verification_code
    {
        return Verification_code::create([
            'user_id' => $this->id,
            'code' => Str::random(50),
            'code_type' => $codeType,
            'expires_at' => now()->addHours($expiryHours),
            'is_verified' => false
        ]);
    }

    /**
     * Get the latest valid verification code
     */
    public function latestVerificationCode(string $codeType): ?Verification_code
    {
        return $this->verificationCodes()
            ->where('code_type', $codeType)
            ->where('expires_at', '>', now())
            ->where('is_verified', false)
            ->latest()
            ->first();
    }
}