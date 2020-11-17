<?php

declare(strict_types=1);

namespace VictorFalcon\LaravelTask\Tests\stub;

use VictorFalcon\LaravelTask\Task;
use VictorFalcon\LaravelTask\Taskable;

class ThrowableTask extends Task
{
    use Taskable;

    public function handle()
    {
        throw new \Exception('Task trigger');
    }
}
