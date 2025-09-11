<?php

namespace App\Services;

use App\Dtos\Endpoint;
use App\Dtos\Parameter;
use Illuminate\Support\Collection;

class EndpointService
{
    protected Collection $endpoints;

    public function __construct()
    {
        $this->endpoints = collect();

        foreach (config('endpoints') as $endpoint) {

            $params = collect();
            foreach ($endpoint['params'] ?? [] as $param) {
                $params->push(new Parameter(
                    $param['name'],
                    $param['required'],
                    $param['type'],
                    $param['description'],
                ));
            }

            $this->endpoints->push(
                new Endpoint(
                    $endpoint['name'],
                    $endpoint['description'],
                    $endpoint['path'],
                    $params,
                    $endpoint['example'],
                    $endpoint['response'],
                )
            );
        }
    }

    public function getAll(): Collection
    {
        return $this->endpoints;
    }

}
