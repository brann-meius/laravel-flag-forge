<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Tests\Unit\Casts;

use InvalidArgumentException;
use Meius\FlagForge\FlagManager;
use Meius\LaravelFlagForge\Facades\Flag;
use Meius\LaravelFlagForge\Tests\Support\Enum\Permission;
use Meius\LaravelFlagForge\Tests\Support\Models\ChatUser;
use Meius\LaravelFlagForge\Tests\TestCase;

class AsMaskTest extends TestCase
{
    public function testWithInteger()
    {
        $chatUser = ChatUser::factory()->make();
        $chatUser->permissions = 16;

        $this->assertInstanceOf(FlagManager::class, $chatUser->permissions);
        $this->assertEquals(16, $chatUser->permissions->getMask());
    }

    public function testWithNumericString()
    {
        $chatUser = ChatUser::factory()->make();
        $chatUser->permissions = '16';

        $this->assertInstanceOf(FlagManager::class, $chatUser->permissions);
        $this->assertEquals(16, $chatUser->permissions->getMask());
    }

    public function testWithNull()
    {
        $chatUser = ChatUser::factory()->make();
        $chatUser->permissions = null;

        $this->assertInstanceOf(FlagManager::class, $chatUser->permissions);
        $this->assertEquals(0, $chatUser->permissions->getMask());
    }

    public function testThrowsExceptionForInvalidType()
    {
        $chatUser = ChatUser::factory()->make();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid value type for saving "permissions": string. ' .
            'Expected an instance of FlagManager, int, or a numeric string.');

        $chatUser->permissions = 'Tanos';
    }

    public function testWithFlagManager()
    {
        $chatUser = ChatUser::factory([
            'permissions' => Flag::combine(Permission::SendMessages, Permission::DeleteMessages, Permission::AddUsers),
        ])->make();

        $this->assertEquals(7, $chatUser->permissions->getMask());
    }
}