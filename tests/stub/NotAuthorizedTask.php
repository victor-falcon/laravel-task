<?php

declare(strict_types=1);

namespace VictorFalcon\LaravelTask\Tests\stub;

use VictorFalcon\LaravelTask\Task;
use VictorFalcon\LaravelTask\Taskable;

class NotAuthorizedTask extends Task
{
    use Taskable;

    public function authorize(): bool
    {
        return false;
    }

    public function handle(): bool
    {
        return true;
    }
}
