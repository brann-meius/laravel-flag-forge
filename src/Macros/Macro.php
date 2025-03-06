<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Macros;

use BadMethodCallException;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Meius\LaravelFlagForge\Contracts\Macros\MacroInterface;

/**
 * Base class for query macros, allowing extension of both Eloquent and Query builders.
 * Each macro must define a `closure` method that will be used as the actual macro implementation.
 *
 * @method EloquentBuilder|QueryBuilder closure Applies a bitwise check on the given column to determine if the flag is set.
 */
abstract class Macro implements MacroInterface
{
    /**
     * The macro name that will be registered.
     */
    protected string $name;

    /**
     * List of builder classes to which the macro should be applied.
     */
    protected array $targets = [
        QueryBuilder::class,
        EloquentBuilder::class,
    ];

    public static function instance(): Macro
    {
        return new static();
    }

    public function register(): void
    {
        if (!method_exists($this, 'closure')) {
            throw new BadMethodCallException(sprintf(
                'The macro class %s must implement a closure method.',
                static::class
            ));
        }

        foreach ($this->getTargets() as $target) {
            $target::macro($this->getName(), [$this, 'closure']);
        }
    }

    /**
     * Retrieves the macro name.
     */
    protected function getName(): string
    {
        return $this->name;
    }

    /**
     * Retrieves the list of target builder classes.
     */
    protected function getTargets(): array
    {
        return $this->targets;
    }

    /**
     * Properly wraps the column name using the builder's query grammar.
     */
    protected function prepareColumn(QueryBuilder|EloquentBuilder $builder, string $column): string
    {
        if ($builder instanceof EloquentBuilder) {
            return $builder->getQuery()->getGrammar()->wrap($column);
        }

        return $builder->getGrammar()->wrap($column);
    }
}