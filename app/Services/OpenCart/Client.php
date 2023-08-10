<?php

namespace App\Services\OpenCart;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;

class Client
{
    const RETRIES = 5;
    const TIMEOUT = 5000;

    public function client(): PendingRequest
    {
        $openCartAccess = "we_get_this_from_user_setting";
        $openCartAccess = "we_get_this_from_user_setting";
        
        return Http::withToken($openCartAccess)
            ->baseUrl($openCartAccess)
            ->retry(self::RETRIES, self::TIMEOUT);
    }
}