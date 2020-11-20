![Laravel Task](https://banners.beyondco.de/Laravel%20Tasks.png?theme=dark&packageName=victor-falcon%2Flaravel-task&pattern=glamorous&style=style_1&description=A+simple+way+to+trigger+actions&md=1&showWatermark=0&fontSize=100px&images=code)

[![GitHub Workflow Status](https://github.com/victor-falcon/laravel-task/workflows/Run%20tests/badge.svg)](https://github.com/victor-falcon/laravel-task/actions)
[![Packagist](https://img.shields.io/packagist/v/victor-falcon/laravel-task.svg)](https://packagist.org/packages/victor-falcon/laravel-task)
[![Packagist](https://poser.pugx.org/victor-falcon/laravel-task/d/total.svg)](https://packagist.org/packages/victor-falcon/laravel-task)
[![Packagist](https://img.shields.io/packagist/l/victor-falcon/laravel-task.svg)](https://packagist.org/packages/victor-falcon/laravel-task)

[🇪🇸 Documentación en español aqui](https://victorfalcon.es/laravel-task/)

**Table of content:**
- [Installation](#installation)
- [Usage](#usage)
	1. [Basic usage](#1-basic-usage)
	2. [With validation](#2-with-validation)
	3. [With authorization](#3-with-authorization)
	4. [Recover response](#4-recover-response)
- [Generate IDE Help](#generate-ide-help)
- [Credits](#credits)

## Installation
Install via composer

```bash
composer require victor-falcon/laravel-task
```

## Usage 
### 1. Basic usage
Create a simple task using:

```
artisan task:make Shop/CreateUserShop
```

> You can pass Shop/CreateUserShop to create the class in a sub-folder or just the task name. The default path is `app/Tasks`.

```php
<?php

declare(strict_types=1);

namespace App\Tasks\Shop;

use VictorFalcon\LaravelTask\Task;
use VictorFalcon\LaravelTask\Taskable;

final class CreateUserShop implements Task
{
	use Taskable;

	private User $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function handle(ShopCreator $creator): Shop
	{
		// Create your shop
	}
}
```

and trigger it:

```php
$shop = CreateUserShop::trigger($user);
```

### 2. With validation
If you want, you can pass validated data to your tasks using the Laravel validator. For example, If you need to validate a user creation you can do something like this.

```php
final class CreateUser implements Task
{
	public function rules(): array
	{
		return [
			'name' => 'required|string|min:5',
			'email' => 'required|email|unique:users,email',
		];
	}

	public function handle(): User
	{
		return User::create($this->data);
	}
}
```

And then you can trigger your task with extra data using:

```php
CreateUser::trigger()->withValid([
	'name' => 'Víctor Falcón',
	'email' => 'hi@victorfalcon.es',
]);
```

You can customize the messages with the method `messages(): array` in your task or add custom attributes with `customAttributes(): array`.

If you want to customize the errors bag name of the validator just define the `string $errorBag` property in your class.

### 3. With authorization
Sometimes you need to check if the user triggering the task is authorized or not. You can do that by adding a simple `authorize(): bool` method to your task. If this method returns `false` an `AuthorizationException` will thrown on before execution.

```php
public function authorize(): bool
{
	return $this->user()->can('create', Product::class);
}
```

In any task you can access to the current logged user with `$this->user()` or, if you want, you can pass a user object by doing:

```php
CreateProduct::trigger()->by($user);
```

### 4. Recover response

By default, each task is executed without returning any value. So if you want to recover the result of a task you must call the `result()` method.

```php
// This will return the result of the `handle` method inside our task
$product = CreateProduct::trigger()->withValid($data)->result();
```

## Generate IDE Help
In order to make more easy to write and use your task you can generate a `_ide_helper_tasks.php` file automatically with the `artisan task:ide-help` command.


## Credits
- [Víctor Falcón](https://github.com/victor-falcon)
- [All contributors](https://github.com/victor-falcon/laravel-task/graphs/contributors)
