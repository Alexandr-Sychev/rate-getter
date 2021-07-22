<?php

namespace App\Services\HttpClient;

use App\Interfaces\HttpClient;
use GuzzleHttp\Client;

class GuzzleHttpClient implements HttpClient
{
    public function __construct()
    {
        $this->client = new Client();
    }

    public function sendGet(string $url)
    {
        return (string)$this->client->get($url)->getBody();
    }
}