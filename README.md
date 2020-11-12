
# 🔥 Laravel Task
###  A simple way to trigger some specific task in a clean and simple way

[![GitHub Workflow Status](https://github.com/victor-falcon/laravel-task/workflows/Run%20tests/badge.svg)](https://github.com/victor-falcon/laravel-task/actions)
[![Packagist](https://img.shields.io/packagist/v/victor-falcon/laravel-task.svg)](https://packagist.org/packages/victor-falcon/laravel-task)
[![Packagist](https://poser.pugx.org/victor-falcon/laravel-task/d/total.svg)](https://packagist.org/packages/victor-falcon/laravel-task)
[![Packagist](https://img.shields.io/packagist/l/victor-falcon/laravel-task.svg)](https://packagist.org/packages/victor-falcon/laravel-task)

## Installation
Install via composer

```bash
composer require victor-falcon/laravel-task
```

## Usage
Create a simple task:

```php
<?php

declare(strict_types=1);

namespace App\Actions\Shop;

use VictorFalcon\LaravelTask\Task;
use VictorFalcon\LaravelTask\Taskable;
  
final class CreateUserShop implements Task
{
	use Taskable;

	private ShopCreator $creator;

	public function __construct(ShopCreator $creator)
	{
		$this->creator = $creator;
	}
  
	public function __invoke(User $user): Shop
	{
		// Create your shop
	}
}
```

and trigger it:

```php
	$shop = CreateUserShop::trigger($user);
```

## Credits
- [Víctor Falcón](https://github.com/victor-falcon)
- [All contributors](https://github.com/victor-falcon/laravel-task/graphs/contributors)

This package is bootstrapped with the help of
[melihovv/laravel-package-generator](https://github.com/melihovv/laravel-package-generator).
