<?php
/**
 * Created by PhpStorm.
 * User: simone
 * Date: 16/10/2018
 * Time: 13:22
 */

use Dotenv\Dotenv;
$dotenv = new Dotenv(__DIR__ . '/..');
$dotenv->load();

class Config
{
    private $todayTime;
    private $tomorrowTime;
    private $afterTomorrowTime;
    private $today;
    private $tomorrow;
    private $afterTomorrow;
    private $calendarUrl = '';
    private $weatherCity = '';
    private $weatherApiKey = '';

    public function __construct()
    {
        try {
            $this->todayTime = new DateTime('today');
            $this->todayTime = $this->todayTime->setTime(0, 0, 0, 0);

            $this->tomorrowTime = clone $this->todayTime;
            $this->tomorrowTime = $this->tomorrowTime->add(new DateInterval('P1D'));

            $this->afterTomorrowTime = clone $this->tomorrowTime;
            $this->afterTomorrowTime = $this->afterTomorrowTime->add(new DateInterval('P1D'));

        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $this->today = $this->todayTime->format('Y-m-d');
        $this->tomorrow = $this->tomorrowTime->format('Y-m-d');
        $this->afterTomorrow = $this->afterTomorrowTime->format('Y-m-d');

        $this->calendarUrl = getenv('ICAL_URL');

        $this->weatherCity = getenv('WEATHER_CITY');
        $this->weatherApiKey = getenv('OPEN_WEATHER_KEY');
    }

    /**
     * @return string
     */
    public function getToday()
    {
        return $this->today;
    }

    /**
     * @return string
     */
    public function getTomorrow()
    {
        return $this->tomorrow;
    }

    /**
     * @return string
     */
    public function getAfterTomorrow()
    {
        return $this->afterTomorrow;
    }

    /**
     * @return string
     */
    public function getCalendarUrl()
    {
        return $this->calendarUrl;
    }

    /**
     * @return string
     */
    public function getWeatherCity()
    {
        return $this->weatherCity;
    }

    /**
     * @return string
     */
    public function getWeatherApiKey()
    {
        return $this->weatherApiKey;
    }

    /**
     * @return DateTime
     */
    public function getTodayTime(): DateTime
    {
        return $this->todayTime;
    }

    /**
     * @return DateTime
     */
    public function getTomorrowTime(): DateTime
    {
        return $this->tomorrowTime;
    }

    /**
     * @return DateTime
     */
    public function getAfterTomorrowTime(): DateTime
    {
        return $this->afterTomorrowTime;
    }

}