<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Tests\Support\Enum;

use Meius\FlagForge\Contracts\Bitwiseable;

enum Permission: int implements Bitwiseable
{
    /**
     * Permission to send messages in the chat.
     */
    case SendMessages = 1 << 0;

    /**
     * Permission to delete messages.
     */
    case DeleteMessages = 1 << 1;

    /**
     * Permission to add new users to the chat.
     */
    case AddUsers = 1 << 2;

    /**
     * Permission to remove users from the chat.
     */
    case RemoveUsers = 1 << 3;

    /**
     * Permission to pin messages in the chat.
     */
    case PinMessages = 1 << 4;

    /**
     * Permission to manage chat settings (e.g. change chat name, description).
     */
    case ManageChat = 1 << 5;

    /**
     * Permission to manage moderators within the chat.
     */
    case ManageModerators = 1 << 6;
}
