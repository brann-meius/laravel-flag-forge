<?php

declare(strict_types=1);

namespace Illuminate\Database\Eloquent {

    use Meius\FlagForge\Contracts\Bitwiseable;
    use Meius\FlagForge\FlagManager;

    if (false) {
        /**
         * This helper class is responsible for extending the functionality of the Eloquent Builder by registering
         * a set of expressive macros for working with bitmask values in database queries. It provides a collection
         * of methods to easily filter records based on bitwise flag operations.
         *
         * This class is intended solely as a helper to register these macros during the application's boot process.
         * It is not meant to be instantiated or used directly in your business logic, and it will not alter or break
         * any existing functionality.
         *
         * @method $this whereHasFlag(string $column, Bitwiseable $flag)
         * @method $this whereDoesntHaveFlag(string $column, Bitwiseable $flag)
         * @method $this whereAllFlagsSet(string $column, Bitwiseable[]|FlagManager $manager)
         * @method $this whereAnyFlagSet(string $column, Bitwiseable[]|FlagManager $manager)
         * @method $this orWhereHasFlag(string $column, Bitwiseable $flag)
         * @method $this orWhereDoesntHaveFlag(string $column, Bitwiseable $flag)
         * @method $this orWhereAllFlagsSet(string $column, Bitwiseable[]|FlagManager $manager)
         * @method $this orWhereAnyFlagSet(string $column, Bitwiseable[]|FlagManager $manager)
         */
        class Builder
        {
            //
        }
    }
}
