<?php

namespace App\Interfaces;

interface HttpClient
{
    public function sendGet(string $url);
}