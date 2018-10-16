<?php
/**
 * Created by PhpStorm.
 * User: simone
 * Date: 16/10/2018
 * Time: 13:10
 */

include '../vendor/autoload.php';

$config = new Config();

$parsed = [
    'today'         => [
        'min'     => 9999,
        'max'     => -9999,
        'weather' => '',
    ],
    'tomorrow'      => [
        'min'     => 9999,
        'max'     => -9999,
        'weather' => '',
    ],
    'afterTomorrow' => [
        'min'     => 9999,
        'max'     => -9999,
        'weather' => '',
    ],
];

if (!$config->getWeatherApiKey() || !$config->getWeatherCity()) {
    header('Content-Type: application/json');
    echo json_encode($parsed);
    exit;
}

$url = 'https://api.openweathermap.org/data/2.5/forecast?APPID=' . $config->getWeatherApiKey() . '&units=metric&q=' . $config->getWeatherCity();
$data = json_decode(file_get_contents($url));

function updateMinMax($item, $parsed, $day)
{
    if ($item->main->temp < $parsed[$day]['min']) {
        $parsed[$day]['min'] = intval($item->main->temp);
    }
    if ($item->main->temp > $parsed[$day]['max']) {
        $parsed[$day]['max'] = intval($item->main->temp);
    }
    return $parsed;
}

function getWeatherIcon($weather) {
    switch ($weather) {
        case 'clear sky':
            return 'fa-sun';
    }
}

foreach ($data->list as $item) {
    if ($item->dt < $config->getTomorrowTime()->getTimestamp()) {
        $parsed = updateMinMax($item, $parsed, 'today');
        if ($parsed['today']['weather'] == '') {
            $parsed['today']['weather'] = getWeatherIcon($item->weather[0]->description);
        }

    } elseif ($item->dt < $config->getAfterTomorrowTime()->getTimestamp()) {
        $parsed = updateMinMax($item, $parsed, 'tomorrow');
        if (strpos($item->dt_txt, ' 12:00') !== false) {
            $parsed['tomorrow']['weather'] = getWeatherIcon($item->weather[0]->description);
        }

    } elseif ($item->dt < $config->getAfterTomorrowTime()->getTimestamp() + 86400) {
        $parsed = updateMinMax($item, $parsed, 'afterTomorrow');
        if (strpos($item->dt_txt, ' 12:00') !== false) {
            $parsed['afterTomorrow']['weather'] = getWeatherIcon($item->weather[0]->description);
        }
    }
}

header('Content-Type: application/json');
echo json_encode($parsed);
