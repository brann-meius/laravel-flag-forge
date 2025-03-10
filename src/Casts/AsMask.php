<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Meius\FlagForge\Contracts\Bitwiseable;
use Meius\FlagForge\FlagManager;

class AsMask implements CastsAttributes
{
    public function __construct(
        /**
         * @var class-string<Bitwiseable> $enum
         */
        private readonly string $enum
    ) {
        //
    }

    public function get(Model $model, string $key, mixed $value, array $attributes): FlagManager
    {
        if (is_int($value) || is_numeric($value) || is_null($value)) {
            return new class ((int)$value, $this->enum) extends FlagManager {
                public function __construct(int $mask, protected string $enum)
                {
                    parent::__construct($mask);
                }
            };
        }

        throw new InvalidArgumentException(sprintf(
            'Invalid value type for casting "%s": %s. Expected an int or a numeric string.',
            $key,
            gettype($value)
        ));
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): int
    {
        if ($value instanceof FlagManager) {
            return $value->getMask();
        }

        if (is_int($value) || is_numeric($value) || is_null($value)) {
            return (int)$value;
        }

        throw new InvalidArgumentException(sprintf(
            'Invalid value type for saving "%s": %s. Expected an instance of FlagManager, int, or a numeric string.',
            $key,
            gettype($value)
        ));
    }
}
