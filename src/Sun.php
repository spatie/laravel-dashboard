<?php

namespace Spatie\Dashboard;

use Illuminate\Support\Carbon;

class Sun
{
    protected float $lat;

    protected float $lng;

    public function __construct(float $lat, float $lng)
    {
        $this->lat = $lat;

        $this->lng = $lng;
    }

    public function sunIsUp(Carbon $onDay = null): bool
    {
        $sunrise = $this->sunrise($onDay);
        $sunset = $this->sunset($onDay);

        return Carbon::now()->between($sunrise, $sunset);
    }

    public function sunrise(Carbon $onDay = null): Carbon
    {
        $onDay = $onDay ?? Carbon::now();

        $sunriseTimestamp = date_sunrise(
            $onDay->timestamp,
            SUNFUNCS_RET_TIMESTAMP,
            $this->lat,
            $this->lng
        );

        return Carbon::createFromTimestamp($sunriseTimestamp);
    }

    public function sunset(Carbon $onDay = null): Carbon
    {
        $onDay = $onDay ?? Carbon::now();

        $sunsetTimestamp = date_sunset(
            $onDay->timestamp,
            SUNFUNCS_RET_TIMESTAMP,
            $this->lat,
            $this->lng
        );

        return Carbon::createFromTimestamp($sunsetTimestamp);
    }
}
