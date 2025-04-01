<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * Apply all relevant filters.
     *
     * @param Builder $query
     * @param array<string, mixed> $filters
     * @return Builder
     */
    public function scopeFilter(Builder $query, array $filters = []) : Builder
    {
        $filterClass = 'App\\Filters\\' .class_basename($this). 'Filters';

        $filterClass = new $filterClass($filters);

        return $filterClass->apply($query);
    }
}
