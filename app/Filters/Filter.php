<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Filter
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function receivedFilters(): array
    {
        return $this->filters ?: request()->query();
    }

    /**
     * The builder instance.
     *
     * @var Builder
     */
    protected Builder $builder;

    public function apply(Builder $builder) : Builder
    {
        foreach ($this->receivedFilters() as $name => $value) {

            $this->builder = $builder;

            $method = Str::camel($name);

            if (method_exists($this, $method)) {
                call_user_func_array([$this, $method], [$value]);
            }
        }

        return $builder;
    }
}
