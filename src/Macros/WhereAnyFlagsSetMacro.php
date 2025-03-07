<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Macros;

use Closure;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Meius\FlagForge\FlagManager;
use Meius\LaravelFlagForge\Facades\Flag;

class WhereAnyFlagsSetMacro extends Macro
{
    protected string $name = 'whereAnyFlagsSet';

    public function getClosure(): Closure
    {
        $conductor = $this;

        return function (string $column, FlagManager|array $manager) use ($conductor): EloquentBuilder|QueryBuilder {
            /** @var EloquentBuilder|QueryBuilder $this */
            $column = $conductor->prepareColumn($this, $column);
            if (is_array($manager)) {
                $manager = Flag::combine(...$manager);
            }

            return $this->whereRaw(sprintf("(%s & ?) != 0", $column), [
                $manager,
            ]);
        };
    }
}