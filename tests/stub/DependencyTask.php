<?php

declare(strict_types=1);

namespace VictorFalcon\LaravelTask\Tests\stub;

use VictorFalcon\LaravelTask\Console\Commands\MakeTaskCommand;
use VictorFalcon\LaravelTask\Task;
use VictorFalcon\LaravelTask\Taskable;

class DependencyTask extends Task
{
    use Taskable;

    private string $anyParam;

    public function __construct(string $anyParam)
    {
        $this->anyParam = $anyParam;
    }

    public function handle(MakeTaskCommand $command): string
    {
        return $this->anyParam;
    }
}
