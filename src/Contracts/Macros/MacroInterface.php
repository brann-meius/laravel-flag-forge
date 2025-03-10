<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Contracts\Macros;

use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Database\Query\Builder as QBuilder;

interface MacroInterface
{
    /**
     * Create a new instance of the macro.
     */
    public static function instance(): self;

    /**
     * Registers a macro for the specified builder.
     *
     * This method adds a custom macro to the given builder,
     * extending its functionality.
     *
     * @param class-string<EBuilder|QBuilder> $builder The builder class to register the macro for.
     */
    public function registerFor(string $builder): void;
}
