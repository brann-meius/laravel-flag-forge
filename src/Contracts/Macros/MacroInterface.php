<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Contracts\Macros;

interface MacroInterface
{
    /**
     * Create a new instance of the macro.
     */
    public static function instance(): self;

    /**
     * Registers the macro in the target builder classes..
     */
    public function register(): void;
}