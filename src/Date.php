<?php

namespace Oilstone\Support;

use Carbon\Carbon;

/**
 * Class Date
 * @package App\Services\Helpers
 */
class Date
{
    /**
     * @param string|Carbon $startDate
     * @param string|Carbon $endDate
     * @return string
     */
    public static function toRangeFormat($startDate, $endDate): string
    {
        $startDate = new Carbon($startDate);
        $endDate = new Carbon($endDate);

        if ($startDate->isSameDay($endDate)) {
            return $startDate->format('l j F Y');
        }

        if ($startDate->isSameMonth($endDate)) {
            return $startDate->format('j') . ' - ' . $endDate->format('j F Y');
        }

        if ($startDate->isSameYear($endDate)) {
            return $startDate->format('j F Y ') . ' - ' . $endDate->format('j F Y');
        }

        return $startDate->format('j F') . ' - ' . $endDate->format('j F Y');
    }

    /**
     * @param string|Carbon $startDate
     * @param int $limit
     * @return bool
     */
    public static function isStartingSoon($startDate, int $limit = 15): bool
    {
        $startDate = new Carbon($startDate);

        return $startDate->gt(Carbon::now()) && $startDate->lt(Carbon::now()->addDays($limit));
    }

    /**
     * @param string|Carbon $endDate
     * @param int $limit
     * @return bool
     */
    public static function isEndingSoon($endDate, int $limit = 15): bool
    {
        $endDate = new Carbon($endDate);

        return $endDate->gte(Carbon::now()->format('Y-m-d')) && $endDate->lt(Carbon::now()->addDays($limit));
    }
}
