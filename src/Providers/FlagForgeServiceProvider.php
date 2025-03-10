<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Providers;

use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Database\Query\Builder as QBuilder;
use Illuminate\Support\ServiceProvider;
use Meius\FlagForge\FlagManager;
use Meius\LaravelFlagForge\Console\EnumMakeCommand;
use Meius\LaravelFlagForge\Macros\Macro;
use Meius\LaravelFlagForge\Macros\WhereAllFlagsSetMacro;
use Meius\LaravelFlagForge\Macros\WhereAnyFlagSetMacro;
use Meius\LaravelFlagForge\Macros\WhereDoesntHaveFlagMacro;
use Meius\LaravelFlagForge\Macros\WhereHasFlagMacro;

/**
 * @codeCoverageIgnore
 */
class FlagForgeServiceProvider extends ServiceProvider
{
    protected array $macroTarget = [
        EBuilder::class,
        QBuilder::class,
    ];

    protected array $macros = [
        WhereAllFlagsSetMacro::class,
        WhereAnyFlagSetMacro::class,
        WhereDoesntHaveFlagMacro::class,
        WhereHasFlagMacro::class,
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
        foreach ($this->macroTarget as $builder) {
            foreach ($this->macros as $macro) {
                /** @var Macro $macro */
                $macro::instance()->registerFor($builder);
            }
        }
    }
}
