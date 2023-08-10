<?php

namespace App\Services\Magento;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;

class Client
{
    const RETRIES = 5;
    const TIMEOUT = 5000;

    public function client(): PendingRequest
    {
        $magentoAccess = "we_get_this_from_user_setting";
        $magentoBaseUrl = "we_get_this_from_user_setting";
        
        return Http::withToken($magentoAccess)
            ->baseUrl($magentoBaseUrl)
            ->retry(self::RETRIES, self::TIMEOUT);
    }
}