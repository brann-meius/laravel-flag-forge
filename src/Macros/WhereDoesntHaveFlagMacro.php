<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Macros;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Meius\FlagForge\Contracts\Bitwiseable;

class WhereDoesntHaveFlagMacro extends Macro
{
    protected string $name = 'whereDoesntHaveFlag';

    public function closure(string $column, Bitwiseable $flag): EloquentBuilder|QueryBuilder
    {
        /**
         * @var self|EloquentBuilder|QueryBuilder $this
         */
        return $this->whereRaw(sprintf("(%s & ?) = 0", $this->prepareColumn($this, $column)), [
            $flag->value,
        ]);
    }
}