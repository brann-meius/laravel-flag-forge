<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Macros;

use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Database\Query\Builder as QBuilder;
use Meius\FlagForge\Contracts\Bitwiseable;

class WhereDoesntHaveFlagMacro extends Macro
{
    public const SQL = '(%s & ?) = 0';

    /**
     * @param class-string<EBuilder|QBuilder> $builder
     */
    public function registerFor(string $builder): void
    {
        $prepareColumn = $this->prepareColumn(...);

        $builder::macro('whereDoesntHaveFlag', function (
            string $column,
            Bitwiseable $flag
        ) use ($prepareColumn): EBuilder|QBuilder {
            /** @var EBuilder|QBuilder $this */
            return $this->whereRaw(sprintf(WhereDoesntHaveFlagMacro::SQL, $prepareColumn($this, $column)), [
                $flag->value,
            ]);
        });

        $builder::macro('orWhereDoesntHaveFlag', function (
            string $column,
            Bitwiseable $flag
        ) use ($prepareColumn): EBuilder|QBuilder {
            /** @var EBuilder|QBuilder $this */
            return $this->orWhereRaw(sprintf(WhereDoesntHaveFlagMacro::SQL, $prepareColumn($this, $column)), [
                $flag->value,
            ]);
        });
    }
}