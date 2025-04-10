<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Tests\Unit\Macros;

use Meius\LaravelFlagForge\Tests\Support\Enum\Permission;
use Meius\LaravelFlagForge\Tests\Support\Models\ChatUser;
use Meius\LaravelFlagForge\Tests\TestCase;

class WhereDoesntHaveFlagMacroTest extends TestCase
{
    public function testWhereAllFlagsSetMacroSuccessfulConnect(): void
    {
        $builder = ChatUser::query()
            ->whereDoesntHaveFlag('permissions', Permission::AddUsers)
            ->whereDoesntHaveFlag('permissions', Permission::RemoveUsers);

        $this->assertEquals(/** @lang text */
            'select * from "chat_user" where ("permissions" & ?) = 0 and ("permissions" & ?) = 0',
            $builder->toSql()
        );
    }
    public function testWhereAndOrWhereAllFlagsSetMacroSuccessfulConnect(): void
    {
        $builder = ChatUser::query()
            ->whereDoesntHaveFlag('permissions', Permission::AddUsers)
            ->orWhereDoesntHaveFlag('permissions', Permission::RemoveUsers);

        $this->assertEquals(/** @lang text */
            'select * from "chat_user" where ("permissions" & ?) = 0 or ("permissions" & ?) = 0',
            $builder->toSql()
        );
    }
}
