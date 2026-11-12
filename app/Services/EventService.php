<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use SortDirection;

class EventService
{
    public static function getEvents(): Collection
    {
        $cacheTTL = 60 * 60 * 24 * 5; // 5 days

        return Cache::remember('events', $cacheTTL, function () {
            return Event::query()
                ->select('t.*')
                ->selectRaw("
                CASE
                    WHEN CURDATE() BETWEEN t.actual_start_date AND t.actual_end_date
                    THEN 1
                    ELSE 0
                END AS is_active
            ")
                ->fromSub(function (Builder $q) {
                    $q->select('*')
                        ->selectRaw("STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', start_date), '%Y-%m-%d') AS actual_start_date")
                        ->selectRaw("STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', end_date), '%Y-%m-%d') AS actual_end_date")
                        ->selectRaw("
                        CASE
                            WHEN STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', start_date), '%Y-%m-%d') >= CURDATE()
                            THEN STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', start_date), '%Y-%m-%d')
                            ELSE STR_TO_DATE(CONCAT(YEAR(CURDATE())+1, '-', start_date), '%Y-%m-%d')
                        END AS next_start_date
                     ")
                        ->from('events');
                }, 't')
                ->orderBy('is_permanent', SortDirection::Descending)
                ->orderBy('is_active', SortDirection::Descending)
                ->orderBy('next_start_date')
                ->get();
        });
    }
}
