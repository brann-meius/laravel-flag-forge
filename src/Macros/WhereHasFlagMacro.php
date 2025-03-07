<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Macros;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Meius\FlagForge\Contracts\Bitwiseable;

class WhereHasFlagMacro extends Macro
{
    protected string $name = 'whereHasFlag';

    /**
     * @param Bitwiseable $value
     */
    public function closure(string $column, $value): EloquentBuilder|QueryBuilder
    {
        /** @var self|EloquentBuilder|QueryBuilder $this */
        return $this->whereRaw(sprintf("(%s & ?) = ?", $this->prepareColumn($this, $column)), [
            $value->value,
            $value->value,
        ]);
    }
}