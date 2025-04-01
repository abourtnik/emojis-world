<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (!defined('LARAVEL_START')) {
            define('LARAVEL_START', microtime(true));
        }

        $this->withoutVite();
    }
}
