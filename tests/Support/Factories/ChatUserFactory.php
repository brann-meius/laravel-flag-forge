<?php

declare(strict_types=1);

namespace Meius\LaravelFlagForge\Tests\Support\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Meius\LaravelFlagForge\Tests\Support\Models\ChatUser;

/**
 * @template TModel of ChatUser
 */
class ChatUserFactory extends Factory
{
    protected $model = ChatUser::class;

    public function definition(): array
    {
        return [
            'id' => fake()->uuid,
            'chat_id' => fake()->uuid,
            'user_id' => fake()->uuid,
            'permissions' => 0,
        ];
    }
}
