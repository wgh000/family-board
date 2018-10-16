# Family Board
A simple family board inspired by DAKboard that can be mounted and run on a Raspberry PI and watched in TV.

Raspberry PI should be prepared as a webserver (apache / nginx).

## Actual Functions
- Calendar (use a single iCal file actually)
- Background image (from bing.com)
- Weather Forecast (using openweathermap.org)

## Install
Create API Key at https://openweathermap.org/appid

```
composer install
cp .env.example .env
```

Fill .env variable as the following example

### Example .env
```
ICAL_URL="https://calendar.google.com/calendar/ical/[...]/basic.ics"
WEATHER_CITY="Moscow,ru"
OPEN_WEATHER_KEY="abcdef1234567890abcdef1234567890"
```

## Future Development
- Installing script
