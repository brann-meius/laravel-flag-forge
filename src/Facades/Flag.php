<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Facades;

use Illuminate\Support\Facades\Facade;
use Meius\FlagForge\Contracts\Bitwiseable;
use Meius\FlagForge\FlagManager;

/**
 * @method static FlagManager add(Bitwiseable $flag)
 * @method static FlagManager remove(Bitwiseable $flag) Removes a flag from the current mask.
 * @method static FlagManager toggle(Bitwiseable ...$flag) Toggles specified flags.
 * @method static FlagManager combine(Bitwiseable ...$flag) Combines multiple flags into the current mask.
 * @method static FlagManager clear() Clears all flags in the current mask.
 * @method static bool has(Bitwiseable $flag) Checks if the specified flag is present in the current mask.
 * @method static bool doesntHave(Bitwiseable $flag) Checks if the specified flag is not present in the current mask.
 * @method static int getMask() Returns the current mask value.
 * @method static Bitwiseable[] toArray()
 *
 * @see FlagManager
 */
class Flag extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'flag.manager';
    }
}
