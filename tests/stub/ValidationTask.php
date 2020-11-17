<?php

declare(strict_types=1);

namespace VictorFalcon\LaravelTask\Tests\stub;

use VictorFalcon\LaravelTask\Task;
use VictorFalcon\LaravelTask\Taskable;

class ValidationTask extends Task
{
    use Taskable;

    public function rules(): array
    {
        return [
            'name' => 'string|min:3',
        ];
    }

    public function __invoke(): array
    {
        return $this->data ?? [];
    }
}
