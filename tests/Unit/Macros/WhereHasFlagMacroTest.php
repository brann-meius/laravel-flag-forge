<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Tests\Unit\Macros;

use Meius\LaravelFlagForge\Tests\Support\Enum\Permission;
use Meius\LaravelFlagForge\Tests\Support\Models\ChatUser;
use Meius\LaravelFlagForge\Tests\TestCase;

class WhereHasFlagMacroTest extends TestCase
{
    public function testWhereAllFlagsSetMacroSuccessfulConnect(): void
    {
        $builder = ChatUser::query()
            ->whereHasFlag('permissions', Permission::AddUsers)
            ->whereHasFlag('permissions', Permission::RemoveUsers);

        $this->assertEquals(/** @lang text */
            'select * from "chat_user" where ("permissions" & ?) = ? and ("permissions" & ?) = ?',
            $builder->toSql()
        );
    }
    public function testWhereAndOrWhereAllFlagsSetMacroSuccessfulConnect(): void
    {
        $builder = ChatUser::query()
            ->whereHasFlag('permissions', Permission::AddUsers)
            ->orWhereHasFlag('permissions', Permission::RemoveUsers);

        $this->assertEquals(/** @lang text */
            'select * from "chat_user" where ("permissions" & ?) = ? or ("permissions" & ?) = ?',
            $builder->toSql()
        );
    }
}
