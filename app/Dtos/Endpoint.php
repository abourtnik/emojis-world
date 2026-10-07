<?php

namespace App\Dtos;

use Illuminate\Support\Collection;
class Endpoint
{
    public string $name;
    public string $description;
    public string $path;
    public Collection $params;
    public string $example;
    public array $response;

    public function __construct(
        string $name,
        string $description,
        string $path,
        Collection $params,
        string $example,
        array $response
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->path = $path;
        $this->params = $params;
        $this->example = $example;
        $this->response = $response;
    }

    public function getUrl(string $path = ''): string
    {
        $protocol = request()->secure() ? 'https://' : 'http://';

        return $protocol .config('app.api_url') .'/v'.config('app.api_version'). $path;
    }

    public function getJsonExample(): false|string
    {
        return json_encode($this->response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
