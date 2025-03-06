<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Providers;

use Illuminate\Support\ServiceProvider;
use Meius\FlagForge\FlagManager;
use Meius\LaravelFlagForge\Console\EnumMakeCommand;
use Meius\LaravelFlagForge\Macros\WhereAllFlagsSetMacro;
use Meius\LaravelFlagForge\Macros\WhereAnyFlagsSetMacro;
use Meius\LaravelFlagForge\Macros\WhereDoesntHaveFlagMacro;
use Meius\LaravelFlagForge\Macros\WhereHasFlagMacro;

/**
 * @codeCoverageIgnore
 */
class FlagForgeServiceProvider extends ServiceProvider
{
    protected array $macros = [
        WhereHasFlagMacro::class,
        WhereDoesntHaveFlagMacro::class,
        WhereAllFlagsSetMacro::class,
        WhereAnyFlagsSetMacro::class,
    ];

    public function register(): void
    {
        $this->app->bind('flag.manager', FlagManager::class);
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                EnumMakeCommand::class,
            ]);
        }

        $this->extendEloquentBuilder();
    }

    /**
     * Extend the Eloquent Builder with the custom macros.
     */
    private function extendEloquentBuilder(): void
    {
        foreach ($this->macros as $macro) {
            $macro::instance()->register();
        }
    }
}