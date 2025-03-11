<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Tests\Unit\Macros\DataProviders;

use Meius\FlagForge\Contracts\Bitwiseable;
use Meius\FlagForge\FlagManager;
use Meius\LaravelFlagForge\Tests\Support\Enum\Permission;

class ManagerDataProvider
{
    public const CHAT_MEMBER_PERMISSIONS = [
        Permission::SendMessages,
        Permission::PinMessages,
    ];

    public const CHAT_ADMIN_PERMISSIONS = [
        Permission::SendMessages,
        Permission::DeleteMessages,
        Permission::AddUsers,
        Permission::RemoveUsers,
        Permission::ManageChat,
        Permission::PinMessages,
    ];

    /**
     * @return array<Bitwiseable[]|FlagManager>
     */
    public static function flagsProvider(): array
    {
        return [
            [
                static::CHAT_MEMBER_PERMISSIONS
            ], [
                (new FlagManager())->combine(...static::CHAT_MEMBER_PERMISSIONS)
            ],
        ];
    }

    public static function mixFlagsProvider(): array
    {
        return [
            [
                static::CHAT_MEMBER_PERMISSIONS,
                static::CHAT_ADMIN_PERMISSIONS,
            ], [
                (new FlagManager())->combine(...static::CHAT_MEMBER_PERMISSIONS),
                static::CHAT_ADMIN_PERMISSIONS,
            ],
            [
                static::CHAT_MEMBER_PERMISSIONS,
                (new FlagManager())->combine(...static::CHAT_ADMIN_PERMISSIONS),
            ], [
                (new FlagManager())->combine(...static::CHAT_MEMBER_PERMISSIONS),
                (new FlagManager())->combine(...static::CHAT_ADMIN_PERMISSIONS),
            ],
        ];
    }
}
