<?php

return [
    'App\Interfaces\HttpClient' => [
        'class' => 'App\Services\HttpClient\CurlHttpClient',
        'singleton' => true
    ],
    // 'App\Interfaces\RateGetter' => [
    //     'class' => 'App\Services\RateGetter\XmlRateGetter',
    //     'singleton' => true
    // ],
];