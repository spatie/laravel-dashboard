<?php

namespace Spatie\Dashboard;

use Illuminate\Support\Carbon;

class Sunrise
{
    protected float $lat;
    protected float $lng;

    public function __construct(float $lat, float $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function sunIsUp(): bool
    {
        $sunriseTimestamp = date_sunrise(
            Carbon::now()->timestamp,
            SUNFUNCS_RET_TIMESTAMP,
            $this->lat,
            $this->lng
        );

        $sunrise = Carbon::createFromTimestamp($sunriseTimestamp);

        $sunsetTimestamp = date_sunset(
            Carbon::now()->timestamp,
            SUNFUNCS_RET_TIMESTAMP,
            $this->lat,
            $this->lng
        );

        $sunset = Carbon::createFromTimestamp($sunsetTimestamp);

        return Carbon::now()->between($sunrise, $sunset);
    }
}
