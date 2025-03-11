<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Macros;

use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Database\Query\Builder as QBuilder;
use Meius\FlagForge\Contracts\Bitwiseable;
use Meius\FlagForge\FlagManager;
use Meius\LaravelFlagForge\Facades\Flag;

class WhereAnyFlagSetMacro extends Macro
{
    public const SQL = '(%s & ?) != 0';

    /**
     * @param class-string<EBuilder|QBuilder> $builder
     */
    public function registerFor(string $builder): void
    {
        $prepareColumn = $this->prepareColumn(...);

        $builder::macro('whereAnyFlagSet', function (
            string $column,
            /** @var Bitwiseable[]|FlagManager $manager */
            array|FlagManager $manager
        ) use ($prepareColumn): EBuilder|QBuilder {
            if (is_array($manager)) {
                $manager = Flag::combine(...$manager);
            }

            /** @var EBuilder|QBuilder $this */
            return $this->whereRaw(sprintf(WhereAnyFlagSetMacro::SQL, $prepareColumn($this, $column)), [
                $manager,
            ]);
        });

        $builder::macro('orWhereAnyFlagSet', function (
            string $column,
            /** @var Bitwiseable[]|FlagManager $manager */
            array|FlagManager $manager
        ) use ($prepareColumn): EBuilder|QBuilder {
            if (is_array($manager)) {
                $manager = Flag::combine(...$manager);
            }

            /** @var EBuilder|QBuilder $this */
            return $this->orWhereRaw(sprintf(WhereAnyFlagSetMacro::SQL, $prepareColumn($this, $column)), [
                $manager,
            ]);
        });
    }
}
