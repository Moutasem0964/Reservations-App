<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class SmsService
{

    public function __construct()
    {
        // No dependencies should be here for now
    }

    public function send(string $phoneNumber, string $message)
    {
        // Log the message for local testing
        Log::info("SMS sent to {$phoneNumber}: {$message}");

        // If you have an SMS API, send the request here
        // Example placeholder for MTN / Syriatel API integration
        /*
        $response = Http::post('https://api.syriatel.com/send-sms', [
            'to' => $phoneNumber,
            'message' => $message,
            'api_key' => config('services.sms.api_key'), // Store credentials in config
        ]);

        return $response->successful();
        */

        return true; // For now, just log the message
    }
}
