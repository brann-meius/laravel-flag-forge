<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Console;

use Symfony\Component\Console\Attribute\AsCommand;
use Illuminate\Foundation\Console\EnumMakeCommand as Command;

/**
 * @codeCoverageIgnore
 */
#[AsCommand(name: 'make:enum')]
class EnumMakeCommand extends Command
{
    protected function getStub(): string
    {
        if ($this->option('bitwise')) {
            return __DIR__ . '/../../resources/stubs/enum.bitwise.stub';
        }

        return parent::getStub();
    }
}