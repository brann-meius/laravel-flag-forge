<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Tests\Unit\Macros;

use Meius\FlagForge\Contracts\Bitwiseable;
use Meius\FlagForge\FlagManager;
use Meius\LaravelFlagForge\Tests\Support\Models\ChatUser;
use Meius\LaravelFlagForge\Tests\TestCase;
use Meius\LaravelFlagForge\Tests\Unit\Macros\DataProviders\ManagerDataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;

class WhereAllFlagsSetMacroTest extends TestCase
{
    /**
     * @param Bitwiseable[]|FlagManager $manager
     */
    #[DataProviderExternal(ManagerDataProvider::class, 'flagsProvider')]
    public function testWhereAllFlagsSetMacroSuccessfulConnect(array|FlagManager $manager): void
    {
        $builder = ChatUser::query()->whereAllFlagsSet('permissions', $manager);

        $this->assertEquals(/** @lang text */
            'select * from "chat_user" where ("permissions" & ?) = ?',
            $builder->toSql()
        );
    }

    /**
     * @param Bitwiseable[]|FlagManager $manager1
     * @param Bitwiseable[]|FlagManager $manager2
     */
    #[DataProviderExternal(ManagerDataProvider::class, 'mixFlagsProvider')]
    public function testWhereAndOrWhereAllFlagsSetMacroSuccessfulConnect(
        array|FlagManager $manager1,
        array|FlagManager $manager2
    ): void {
        $builder = ChatUser::query()
            ->whereAllFlagsSet('permissions', $manager1)
            ->orWhereAllFlagsSet('permissions', $manager2);

        $this->assertEquals(/** @lang text */
            'select * from "chat_user" where ("permissions" & ?) = ? or ("permissions" & ?) = ?',
            $builder->toSql()
        );
    }
}
