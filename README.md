# Laravel Flag Forge Package

[![License](https://img.shields.io/github/license/brann-meius/laravel-flag-forge)](LICENSE)
[![codecov](https://codecov.io/gh/brann-meius/laravel-flag-forge/graph/badge.svg?token=Y5NC43U6ZE)](https://codecov.io/gh/brann-meius/laravel-flag-forge)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/1a96ee301b6943969d5da4b0ed8e99d4)](https://app.codacy.com/gh/brann-meius/laravel-flag-forge/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)
[![PHP Version](https://img.shields.io/badge/php->=8.2-blue)](https://www.php.net/)
[![Laravel Version](https://img.shields.io/badge/laravel->=11.0-red)](https://laravel.com/)

> **Recommendation:** Prior to integrating this wrapper into your application, please review the documentation for the
> underlying library [<ins>`meius/flag-forge`</ins>](https://github.com/brann-meius/flag-forge) to fully grasp its
> foundational
> concepts and operations.

Laravel Flag Forge is a refined and sophisticated extension that effortlessly bridges the gap between the powerful
bitwise flag management capabilities of the core library and the expressive nature of Laravel applications. This package
enhances your project with:

- Seamless Eloquent attribute casting,
- A fluent API for bitwise operations,
- Additional expressive query methods,
- An Artisan command to generate bitwise enum classes,
- And a convenient facade for rapid access to flag operations.

---

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Getting Started](#getting-started)
- [Installation](#installation)
- [Usage](#usage)
  - [1. Creating Bitwise Enums](#1-creating-bitwise-enums)
  - [2. Working with Eloquent (Attribute Casting)](#2-working-with-eloquent-attribute-casting)
  - [3. Mastering Bitwise Operations](#3-mastering-bitwise-operations)
  - [4. Using the Facade](#4-using-the-facade)
  - [5. Leveraging Database Query Methods](#5-leveraging-database-query-methods)
  - [6. Integrating with Authorization Policies](#6-integrating-with-authorization-policies)
- [Support](#support)
- [License](#license)

---

## Features

- **Expressive Bitwise Operations:**  
  Enjoy a comprehensive suite of methods such as `add`, `remove`, `combine`, and `toggle` for
  managing flags in a clear and fluent manner.

- **Elegant Flag Verification:**  
  Utilize the `has` and `doesntHave` methods to effortlessly determine whether a specific flag is active.

- **Database Integration:**  
  Store flags in numeric fields and retrieve them with automatic conversion to a fully featured `FlagManager`
  instance.

- **Eloquent Attribute Casting:**  
  With the `AsMask` cast, numeric bitmask values in your models are instantly transformed into elegant
  `FlagManager` objects.

- **Enhanced Query Methods:**  
  Filter records using expressive methods such as `whereHasFlag`, `whereDoesntHaveFlag`,
  `whereAllFlagsSet`, and `whereAnyFlagSet` for sophisticated query building.

- **Artisan Command:**  
  Generate new bitwise enum classes effortlessly with `php artisan make:bit-enum`.

- **Convenient Facade:**  
  Access and chain flag operations using the provided `Flag` facade for rapid prototyping and production-ready
  code.

---

## Requirements

- **PHP:** >= 8.2
- **Laravel:** >= 11.0

---

## Getting Started

To get started with the `meius/laravel-flag-forge` package, follow the installation instructions below and check out the
usage examples.

---

## Installation

1. **Composer Installation:**  
   Install the package using Composer:

   ```bash
   composer require meius/laravel-flag-forge
   ```

2. **Register the Service Provider:**  
   Manually register the service provider by adding it to your `bootstrap/providers.php` file:

   ```php
   return [
       // Other service providers...
       Meius\LaravelFlagForge\Providers\FlagForgeServiceProvider::class,
   ];
   ```

---

## Usage

### 1. Creating Bitwise Enums

Generate a new bitwise enum class using Laravel's Artisan command. For instance, to create an enum for user permissions:

```bash
  php artisan make:bit-enum {name}
```

This command scaffolds a template class where you can define a series of bitwise flags such as `SendMessages`,
`DeleteMessages`, `AddUsers`, etc. Customize this file to reflect the specific needs of your application.

---

### 2. Working with Eloquent (Attribute Casting)

Harness the power of Laravel's Eloquent by converting numeric bitmask fields into expressive `FlagManager`
instances. Consider the following pivot model example:

```php
namespace App\Models;

use App\Enums\Permission; // Your bitwise enum must implement Bitwiseable
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Meius\LaravelFlagForge\Casts\AsMask;

/**
 * ChatUser Model
 *
 * This eloquent model demonstrates seamless integration of bitwise flag management.
 * The `permissions` attribute is automatically cast to a `FlagManager` instance,
 * allowing for sophisticated flag operations within your domain logic.
 *
 * @property string $id
 * @property string $chat_id
 * @property string $user_id
 * @property int $permissions
 */
class ChatUser extends Pivot
{
    use HasUuids;
        
    protected $fillable = ['permissions'];
    
    protected function casts(): array
    {
        return [
            // `AsMask` converts numeric bitmask values into a `FlagManager` instance.
            // Append the fully qualified bitwise enum class after the colon.
            'permissions' => AsMask::class . ':' . Permission::class,
        ];
    }
}
```

**Example of Eloquent Operations:**

```php
// Retrieve a ChatUser instance
$chatUser = ChatUser::query()->first();

// Verify if the user has the permission to send messages
if ($chatUser->permissions->has(Permission::SendMessages)) {
    echo "User is allowed to send messages.";
}

// Add the DeleteMessages flag to the user's permissions
$chatUser->permissions->add(Permission::DeleteMessages);

// Remove a flag if necessary
$chatUser->permissions->remove(Permission::SendMessages);
```

---

### 3. Mastering Bitwise Operations

The `FlagManager` object provides a robust API to manage bitwise flags with ease. Below are detailed examples of
key methods:

- **Adding Flags:**  
  Append new flags to your configuration:
  ```php
  $flags = Flag::add(Permission::SendMessages);
  $flags->add(Permission::AddUsers);
  ```

- **Removing Flags:**  
  Exclude specific flags:
  ```php
  $flags->remove(Permission::DeleteMessages);
  ```

- **Combining Flags:**  
  Merge multiple flags simultaneously:
  ```php
  $flags = Flag::add(Permission::SendMessages)
      ->combine(Permission::DeleteMessages, Permission::AddUsers);
  ```

- **Toggling Flags:**  
  Switch a flag’s state between active and inactive:
  ```php
  $flags->toggle(Permission::PinMessages);
  ```

- **Flag Verification:**  
  Check if a flag is set or unset:
  ```php
  if ($flags->has(Permission::SendMessages)) {
      // Execute logic when the flag is active
  }
  if ($flags->doesntHave(Permission::RemoveUsers)) {
      // Execute alternative logic when the flag is not active
  }
  ```

Each of these operations is designed to be chainable, promoting a fluent and natural coding style that enhances
readability and maintainability.

---

### 4. Using the Facade

The `Flag` facade grants immediate access to flag management operations. It supports chaining methods for building
complex configurations:

```php
use App\Enums\Permission;
use Meius\LaravelFlagForge\Facades\Flag;

// Create a comprehensive flag manager instance with multiple permissions
$flagManager = Flag::add(Permission::SendMessages)
    ->combine(Permission::DeleteMessages, Permission::AddUsers)
    ->toggle(Permission::PinMessages);

// Alternatively, initialize a flag manager with a single permission for a quick check
$singleFlag = Flag::add(Permission::DeleteMessages);
```

This elegant facade simplifies the process of flag manipulation, allowing you to write succinct, expressive code.

---

### 5. Leveraging Database Query Methods

Laravel Flag Forge enriches your querying capabilities by providing additional methods that allow filtering based on
bitwise flags.

- **Filtering Records with Specific Flags:**

  ```php
  use App\Enums\Permission;
  use App\Models\ChatUser;

  // Retrieve all users who have the SendMessages permission set
  $users = ChatUser::query()
    ->whereHasFlag('permissions', Permission::SendMessages)
    ->get();
  ```

- **Excluding Records Missing Certain Flags:**

  ```php
  // Retrieve users who do not have the RemoveUsers flag
  $users = ChatUser::query()
      ->whereDoesntHaveFlag('permissions', Permission::RemoveUsers)
      ->get();
  ```

- **Combining Conditions with Expressive Methods:**

  ```php
  use Meius\LaravelFlagForge\Facades\Flag;

  // Retrieve users who have either the combination of SendMessages and AddUsers or the composite flag built dynamically
  $users = ChatUser::query()
    ->whereAllFlagsSet('permissions', [Permission::SendMessages, Permission::AddUsers])
    ->orWhereAllFlagsSet('permissions', Flag::add(Permission::DeleteMessages)
    ->combine(Permission::PinMessages))
    ->get();
  ```

- **Retrieving Records with Any of Multiple Flags Set:**

  ```php
  // Retrieve users who have at least one flag among RemoveUsers or PinMessages set
  $users = ChatUser::query()
    ->whereAnyFlagSet('permissions', Flag::add(Permission::RemoveUsers)->add(Permission::PinMessages))
    ->get();
  ```

These query methods empower you to create finely tuned database queries, ensuring that your application logic remains
both robust and highly expressive.

---

### 6. Integrating with Authorization Policies

Seamlessly integrate bitwise flag management into Laravel’s authorization system. For example, consider a policy
governing chat interactions. You can employ flag checks directly within policy methods to enforce nuanced permissions:

```php
namespace App\Policies;

use App\Models\User;
use App\Models\Chat;
use App\Enums\Permission;

class ChatPolicy
{
    /**
     * Determine whether the user can send messages.
     */
    public function send(User $user, Chat $chat): bool
    {
        return $user->chats()
            ->where('id', '=', $chat->id)
            ->whereHasFlag('permissions', Permission::SendMessages)
            ->exists();
    }

    /**
     * Determine whether the user can moderate the chat.
     */
    public function update(User $user, Chat $chat): bool
    {
        return $user->chats()
            ->where('id', '=', $chat->id)
            ->whereHasFlag('permissions', Permission::ManageChat)
            ->exists();
    }
    
    /**
    * Determine whether the auth user can exclude the user from the chat.
    */
    public function exclude(User $auth, Chat $chat, User $user): bool
    {
        return $auth->id === $user->id || $auth->chats()
            ->where('id', '=', $chat->id)
            ->whereHasFlag('permissions', Permission::RemoveUsers)
            ->exists();
    }
}
```

This integration ensures that your authorization logic remains expressive and perfectly aligned with the dynamic nature
of bitwise permissions.

---

## Support

For support, please open an issue on the [GitHub repository](https://github.com/brann-meius/laravel-flag-forge/issues).

### Contributing

We welcome contributions to the `meius/laravel-flag-forge` library. To contribute, follow these steps:

1. **Fork the Repository**: Fork the repository on GitHub and clone it to your local machine.
2. **Create a Branch**: Create a new branch for your feature or bugfix.
3. **Write Tests**: Write tests to cover your changes.
4. **Run Tests**: Ensure all tests pass by running `phpunit`.
5. **Submit a Pull Request**: Submit a pull request with a clear description of your changes.

For more details, refer to the [CONTRIBUTING.md](CONTRIBUTING.md) file.

---

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).