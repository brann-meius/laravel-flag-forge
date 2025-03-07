<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Macros;

use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Database\Query\Builder as QBuilder;
use Meius\FlagForge\Contracts\Bitwiseable;

class WhereHasFlagMacro extends Macro
{
    /**
     * @param class-string<EBuilder|QBuilder> $builder
     */
    public function registerFor(string $builder): void
    {
        $prepareColumn = $this->prepareColumn(...);

        $builder::macro('whereHasFlag', function (
            string $column,
            Bitwiseable $flag
        ) use ($prepareColumn): EBuilder|QBuilder {
            /** @var EBuilder|QBuilder $this */
            return $this->whereRaw(sprintf("(%s & ?) = ?", $prepareColumn($this, $column)), [
                $flag->value,
                $flag->value
            ]);
        });
    }
}