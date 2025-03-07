<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Console;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Attribute\AsCommand;

/**
 * @codeCoverageIgnore
 */
#[AsCommand(
    name: 'make:bit-enum',
    description: 'Create a new bitwise enum class',
)]
class EnumMakeCommand extends GeneratorCommand
{
    use CreatesMatchingTest;

    protected $type = 'Enum';

    protected function getStub(): string
    {
        return __DIR__ . '/../../resources/stubs/enum.bitwise.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return match (true) {
            is_dir(app_path('Enumerations')) => $rootNamespace.'\\Enumerations',
            default => $rootNamespace.'\\Enums',
        };
    }
}