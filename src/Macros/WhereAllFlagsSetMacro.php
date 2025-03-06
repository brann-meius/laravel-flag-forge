<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Macros;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Meius\FlagForge\Contracts\Bitwiseable;
use Meius\FlagForge\FlagManager;
use Meius\LaravelFlagForge\Facades\Flag;

class WhereAllFlagsSetMacro extends Macro
{
    protected string $name = 'whereAllFlagsSet';

    /**
     * @param FlagManager|Bitwiseable[] $manager
     */
    public function closure(string $column, array|FlagManager $manager): EloquentBuilder|QueryBuilder
    {
        if (is_array($manager)) {
            $manager = Flag::combine(...$manager);
        }

        /**
         * @var self|EloquentBuilder|QueryBuilder $this
         */
        return $this->whereRaw(sprintf("(%s & ?) = ?", $this->prepareColumn($this, $column)), [
            $manager,
            $manager,
        ]);
    }
}