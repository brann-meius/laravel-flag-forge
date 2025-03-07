<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Macros;

use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Database\Query\Builder as QBuilder;
use Meius\FlagForge\Contracts\Bitwiseable;
use Meius\FlagForge\FlagManager;
use Meius\LaravelFlagForge\Facades\Flag;

class WhereAllFlagsSetMacro extends Macro
{
    /**
     * @param class-string<EBuilder|QBuilder> $builder
     */
    public function registerFor(string $builder): void
    {
        $prepareColumn = $this->prepareColumn(...);

        $builder::macro('whereAllFlagsSet', function (
            string $column,
            /** @var Bitwiseable[]|FlagManager $manager */
            array|FlagManager $manager
        ) use ($prepareColumn): EBuilder|QBuilder {
            if (is_array($manager)) {
                $manager = Flag::combine(...$manager);
            }

            /** @var EBuilder|QBuilder $this */
            return $this->whereRaw(sprintf("(%s & ?) = ?", $prepareColumn($this, $column)), [
                $manager,
                $manager,
            ]);
        });
    }
}