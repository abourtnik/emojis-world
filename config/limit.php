<?php

return [
    'enabled' => env('RATE_LIMIT_ENABLED', false),
    'value' => env('RATE_LIMIT', 100),
];
