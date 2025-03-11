<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Tests\Support\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;
use Illuminate\Database\Eloquent\Model;

class AsInvalidMask implements CastsInboundAttributes
{
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        return $value;
    }
}
