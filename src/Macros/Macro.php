<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Macros;

use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Database\Query\Builder as QBuilder;
use Meius\LaravelFlagForge\Contracts\Macros\MacroInterface;

/** @phpstan-consistent-constructor */
abstract class Macro implements MacroInterface
{
    public static function instance(): static
    {
        return new static();
    }

    /**
     * Properly wraps the column name using the builder's query grammar.
     */
    public function prepareColumn(EBuilder|QBuilder $builder, string $column): string
    {
        if ($builder instanceof EBuilder) {
            $builder = $builder->getQuery();
        }

        return $builder->getGrammar()->wrap($column);
    }
}
