<?php
/**
 * Created by PhpStorm.
 * User: simone
 * Date: 12/10/2018
 * Time: 10:48
 */

include '../vendor/autoload.php';

use Sabre\VObject\Reader;

$config = new Config();

$data = file_get_contents($config->getCalendarUrl());

$vcal = Reader::read($data);

$newVCalendar = $vcal->expand($config->getTodayTime(), $config->getAfterTomorrowTime()->setTime(23, 59, 59));

$events = [
    'today' => [],
    'tomorrow' => [],
    'afterTomorrow' => [],
];

if ($newVCalendar->VEVENT) {
    foreach ($newVCalendar->VEVENT as $event) {
        if ($config->getToday() === $event->DTSTART->getDateTime()->format('Y-m-d')) {
            $events['today'][] = [
                'time' => $event->DTSTART->getDateTime()->format('H:i'),
                'summary' => (string) $event->SUMMARY,
            ];
        }
        if ($config->getTomorrow() === $event->DTSTART->getDateTime()->format('Y-m-d')) {
            $events['tomorrow'][] = [
                'time' => $event->DTSTART->getDateTime()->format('H:i'),
                'summary' => (string) $event->SUMMARY,
            ];
        }
        if ($config->getAfterTomorrow() === $event->DTSTART->getDateTime()->format('Y-m-d')) {
            $events['afterTomorrow'][] = [
                'time' => $event->DTSTART->getDateTime()->format('H:i'),
                'summary' => (string) $event->SUMMARY,
            ];
        }
    }
}

echo json_encode($events);