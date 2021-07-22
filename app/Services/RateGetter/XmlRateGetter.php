<?php

namespace App\Services\RateGetter;

use App\Core\ServiceLocator;
use App\Interfaces\RateGetter as RateGetterInterface;
use App\Interfaces\HttpClient;
use DOMDocument;
use Exception;

class XmlRateGetter implements RateGetterInterface
{
    protected const URL = 'https://www.cbr-xml-daily.ru/daily_utf8.xml';
    protected const VALUTE_NAME = 'Доллар США';

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
        $domXml = new DOMDocument();
        $domXml->loadXML(htmlspecialchars_decode($response));
        $valutes = $domXml->getElementsByTagName('Valute');

        foreach ($valutes as $valute) {
            $valuteName = $valute->getElementsByTagName('Name')[0]->nodeValue;

            if ($valuteName === self::VALUTE_NAME) {
                $value = $valute->getElementsByTagName('Value')[0]->nodeValue;
                $value = preg_replace('/,/', '.', $value);

                return $value;
            }
        }

        throw new Exception('В ответе нет нужной валюты');
    }
}
