<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Tests\Support;

use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    protected $connection = 'mysql';

    protected $guarded = [];
}