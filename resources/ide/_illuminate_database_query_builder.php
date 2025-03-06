<?php

declare(strict_types=1);

namespace Illuminate\Database\Query {

    use Meius\FlagForge\Contracts\Bitwiseable;
    use Meius\FlagForge\FlagManager;

    if (false) {
        /**
         * This helper class is responsible for extending the functionality of the Query Builder by registering
         * a set of expressive macros for working with bitmask values in database queries. It provides a collection
         * of methods to easily filter records based on bitwise flag operations.
         *
         * This class is intended solely as a helper to register these macros during the application's boot process.
         * It is not meant to be instantiated or used directly in your business logic, and it will not alter or break
         * any existing functionality.
         *
         * @method Builder whereHasFlag(string $column, Bitwiseable $flag)
         * @method Builder whereDoesntHaveFlag(string $column, Bitwiseable $flag)
         * @method Builder whereAllFlagsSet(string $column, Bitwiseable[]|FlagManager $manager)
         * @method Builder whereAnyFlagSet(string $column, Bitwiseable[]|FlagManager $manager)
         */
        class Builder
        {
            //
        }
    }
}