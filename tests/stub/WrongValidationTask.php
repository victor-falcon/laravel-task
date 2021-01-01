<?php

declare(strict_types=1);

namespace VictorFalcon\LaravelTask\Tests\stub;

use VictorFalcon\LaravelTask\Task;
use VictorFalcon\LaravelTask\Taskable;

class WrongValidationTask extends Task
{
    use Taskable;

    public function rules(): array
    {
        return [
            'name' => 'invalida_validation_rule',
        ];
    }

    public function handle(): array
    {
        return $this->data ?? [];
    }
}
