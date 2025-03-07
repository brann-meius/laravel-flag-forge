<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Macros;

use Closure;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Meius\FlagForge\Contracts\Bitwiseable;

class WhereDoesntHaveFlagMacro extends Macro
{
    protected string $name = 'whereDoesntHaveFlag';

    public function getClosure(): Closure
    {
        $conductor = $this;

        return function (string $column, Bitwiseable $flag) use ($conductor): EloquentBuilder|QueryBuilder {
            /** @var EloquentBuilder|QueryBuilder $this */
            $column = $conductor->prepareColumn($this, $column);

            return $this->whereRaw(sprintf("(%s & ?) = 0", $column), [
                $flag->value,
            ]);
        };
    }
}