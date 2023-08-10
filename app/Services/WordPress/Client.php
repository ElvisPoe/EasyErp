<?php

namespace App\Services\WordPress;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;

class Client
{
    const RETRIES = 5;
    const TIMEOUT = 5000;

    public function client(): PendingRequest
    {
        $wordPressAccess = "we_get_this_from_user_setting";
        $wordPressBaseUrl = "we_get_this_from_user_setting";
        
        return Http::withToken($wordPressAccess)
            ->baseUrl($wordPressBaseUrl)
            ->retry(self::RETRIES, self::TIMEOUT);
    }
}