<?php

namespace App\Services\RateGetter;

use App\Core\ServiceLocator;
use App\Interfaces\RateGetter as RateGetterInterface;
use App\Interfaces\HttpClient;
use Exception;
use Throwable;

class JsonRateGetter implements RateGetterInterface
{
    protected const URL = 'https://www.cbr-xml-daily.ru/daily_json.js';
    protected const VALUTE_CODE = 'USD';

    protected HttpClient $httpClient;

    public function __construct()
    {
        $serviceLocator = new ServiceLocator();

        $this->httpClient = $serviceLocator->getService('App\Interfaces\HttpClient');
    }

    public function getDollar(): float
    {
        $response = $this->httpClient->sendGet(self::URL);
        $result = $this->parseResponse($response);

        return $result;
    }

    protected function parseResponse($response): float
    {
        $valuteCode = self::VALUTE_CODE;

        try {
            return json_decode($response)->Valute->$valuteCode->Value;
        } catch (Throwable $exception) {
            throw new Exception('Не удалось извлечь нужную валюту');
        }
    }
}
