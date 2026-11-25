<?php

namespace App\Traits;

use DateTimeInterface;

trait SerializeDate
{
    /**
     * Prepare a date for array / JSON serialization.
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format(config('app.date_time_format'));
    }
}
