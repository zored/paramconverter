<?php

use Zored\ParamConverter\ConverterBuilder;

require __DIR__ . '/../vendor/autoload.php';

# This is example of calling static method.
# Why? I have no idea.
$format = 'Y-m-d H:i:s';
$time = '2017-12-20 10:00:00';

$date = ConverterBuilder::create()
    ->build()
    ->apply([\DateTime::class, 'createFromFormat'], [
        'format' => $format,
        'time' => $time,
    ], true);

// Same with method call:
echo $date == \DateTime::createFromFormat($format, $time);

