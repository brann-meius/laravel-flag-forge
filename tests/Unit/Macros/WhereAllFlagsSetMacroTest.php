<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Tests\Unit\Macros;

use Meius\LaravelFlagForge\Facades\Flag;
use Meius\LaravelFlagForge\Tests\Support\Enum\Permission;
use Meius\LaravelFlagForge\Tests\Support\Models\ChatUser;
use Meius\LaravelFlagForge\Tests\TestCase;

class WhereAllFlagsSetMacroTest extends TestCase
{
    public function testWhereAllFlagsSetMacroSuccessfulConnect(): void
    {
        $builder = ChatUser::query()
            ->whereAllFlagsSet('permissions', Flag::combine(
                Permission::AddUsers,
                Permission::RemoveUsers,
                Permission::ManageChat,
            ));

        $this->assertEquals(
            /** @lang text */
            'select * from "chat_user" where ("permissions" & ?) = ?',
            $builder->toSql()
        );
    }
    public function testWhereAndOrWhereAllFlagsSetMacroSuccessfulConnect(): void
    {
        $builder = ChatUser::query()
            ->whereAllFlagsSet('permissions', Flag::combine(
                Permission::AddUsers,
                Permission::RemoveUsers,
                Permission::ManageChat,
            ))
            ->orWhereAllFlagsSet('permissions', Flag::combine(
                Permission::DeleteMessages,
                Permission::PinMessages,
            ));

        $this->assertEquals(
            /** @lang text */
            'select * from "chat_user" where ("permissions" & ?) = ? or ("permissions" & ?) = ?',
            $builder->toSql()
        );
    }
}
