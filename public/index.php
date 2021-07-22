<?php

require '../vendor/autoload.php';

use App\Core\ServiceLocator;

$serviceLocator = new ServiceLocator();

$rateGetter = $serviceLocator->getService('App\Services\RateGetter\XmlRateGetter');

$dollarRate = $rateGetter->getDollar();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <p>Курс доллара: <?= $dollarRate ?></p>
    </div>
</body>
</html>