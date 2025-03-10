<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Tests\Support\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Meius\FlagForge\FlagManager;
use Meius\LaravelFlagForge\Casts\AsMask;
use Meius\LaravelFlagForge\Tests\Support\Enum\Permission;
use Meius\LaravelFlagForge\Tests\Support\Factories\ChatUserFactory;

/**
 * @property string $id
 * @property string $chat_id
 * @property string $user_id
 * @property FlagManager $permissions
 */
class ChatUser extends Pivot
{
    use HasFactory;

    public static string $factory = ChatUserFactory::class;

    protected $fillable = [
        'permissions',
    ];

    protected function casts(): array
    {
        return [
            'permissions' => AsMask::class . ':'. Permission::class,
        ];
    }
}
