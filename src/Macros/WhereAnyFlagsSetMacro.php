<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Macros;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Meius\FlagForge\Contracts\Bitwiseable;
use Meius\FlagForge\FlagManager;
use Meius\LaravelFlagForge\Facades\Flag;

class WhereAnyFlagsSetMacro extends Macro
{
    protected string $name = 'whereAnyFlagsSet';

    /**
     * @param FlagManager|Bitwiseable[] $value
     */
    public function closure(string $column, $value): EloquentBuilder|QueryBuilder
    {
        if (is_array($value)) {
            $value = Flag::combine(...$value);
        }

        /** @var self|EloquentBuilder|QueryBuilder $this */
        return $this->whereRaw(sprintf("(%s & ?) != 0", $this->prepareColumn($this, $column)), [
            $value,
        ]);
    }
}