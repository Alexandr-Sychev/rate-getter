<?php

namespace App\Services\HttpClient;

use App\Interfaces\HttpClient;

class CurlHttpClient implements HttpClient
{
    public function sendGet(string $url)
    {
        $request = curl_init($url);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        
        return curl_exec($request);
    }
}