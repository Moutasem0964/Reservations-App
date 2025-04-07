<?php

namespace App\Traits;

use App\Models\Verification_code;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait HasVerificationCodes
{
    /**
     * Generate a verification code, store it in DB, and cache it.
     */
    public function generateVerificationCode(string $codeType, int $expiryHours = 24): Verification_code
    {
        $code = Str::random(8);
        $verificationCode = Verification_code::create([
            'user_id' => $this->id,
            'code' => $code,
            'code_type' => $codeType,
            'expires_at' => now()->addHours($expiryHours),
            'is_verified' => false
        ]);

        // Cache both the code AND the intent
        $this->cacheVerificationCode($code, $codeType, $expiryHours * 3600);
        $this->cacheVerificationIntent($codeType, $expiryHours * 3600); // ← THIS WAS MISSING

        return $verificationCode;
    }

    /**
     * Cache a verification code with a consistent key structure.
     */
    private function cacheVerificationCode(string $code, string $codeType, int $expirySeconds): void
    {
        $cacheKey = $this->getVerificationCodeCacheKey($codeType);
        Cache::put($cacheKey, $code, $expirySeconds);
    }

    /**
     * Get the cache key for a verification code type.
     */
    private function getVerificationCodeCacheKey(string $codeType): string
    {
        return "vc:{$this->phone_number}:{$codeType}";
    }

    /**
     * Retrieve the latest valid verification code (cache-first).
     */
    public function latestVerificationCode(string $codeType): ?Verification_code
    {
        $cacheKey = $this->getVerificationCodeCacheKey($codeType);
        $cachedCode = Cache::get($cacheKey);

        if (!$cachedCode) {
            return $this->verificationCodes()
                ->where('code_type', $codeType)
                ->where('expires_at', '>', now())
                ->where('is_verified', false)
                ->latest()
                ->first();
        }

        return $this->verificationCodes()
            ->where('code', $cachedCode)
            ->where('code_type', $codeType)
            ->where('expires_at', '>', now())
            ->where('is_verified', false)
            ->first();
    }

    /**
     * Verify a user-provided code against cached/database records.
     */
    public function verifyCode(string $enteredCode): ?Verification_code
    {
        // Trim and standardize input
        $enteredCode = trim($enteredCode);

        // Get the intent (ensure this isn't returning null)
        $codeType = $this->getCachedVerificationIntent();

        if (!$codeType) {
            Log::error('No verification intent found');
            return null;
        }

        // Check cache first
        $cacheKey = $this->getVerificationCodeCacheKey($codeType);
        $cachedCode = Cache::get($cacheKey);

        // Check database regardless of cache
        $codeFromDb = $this->verificationCodes()
            ->where('code', $enteredCode)
            ->where('code_type', $codeType)
            ->where('expires_at', '>', now())
            ->where('is_verified', false)
            ->first();

        return $codeFromDb;
    }

    /**
     * Cache the verification intent (e.g., 'password_reset').
     */
    public function cacheVerificationIntent(string $codeType, int $ttl = 300): void
    {
        Cache::put("verification_intent:{$this->phone_number}", $codeType, $ttl);
    }

    /**
     * Retrieve the cached verification intent.
     */
    public function getCachedVerificationIntent(): ?string
    {
        return Cache::get("verification_intent:{$this->phone_number}");
    }

    /**
     * Handle post-verification actions (e.g., activate user).
     */
    public function handlePostVerification(string $codeType): void
    {
        switch ($codeType) {
            case 'client_registration':
            case 'manager_registration':
            case 'admin_registration':
            case 'employee_registration':
                $this->update(['is_active' => true]);
                break;
        }

        // Cleanup
        Cache::forget("verification_intent:{$this->phone_number}");
        Cache::forget($this->getVerificationCodeCacheKey($codeType));
    }
}
