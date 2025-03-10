<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Tests;

use Meius\LaravelFlagForge\Providers\FlagForgeServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Orchestra\Workbench\WorkbenchServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->register(FlagForgeServiceProvider::class);
        $this->app->register(WorkbenchServiceProvider::class);
    }
}