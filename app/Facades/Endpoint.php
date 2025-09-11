<?php

namespace App\Facades;

use App\Services\EndpointService;
use Illuminate\Support\Facades\Facade;

class Endpoint extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return EndpointService::class;
    }
}
