<?php

declare(strict_types=1);

namespace VictorFalcon\LaravelTask\Tests\stub;

use VictorFalcon\LaravelTask\Task;
use VictorFalcon\LaravelTask\Taskable;

class BasicTask extends Task
{
    use Taskable;

    public function __invoke(bool $input): bool
    {
        return $input;
    }
}
