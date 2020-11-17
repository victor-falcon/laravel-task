<?php

declare(strict_types=1);

namespace VictorFalcon\LaravelTask;

use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Validator;

class PendingTrigger
{
    protected Task $task;
    protected array $arguments;

    public function __construct(Task $task, ?array $arguments)
    {
        $this->task = $task;
        $this->arguments = $arguments ?? [];
    }

    public function withValidation(array $data): self
    {
        if (method_exists($this->task, 'rules')) {
            $rules = $this->task->rules();
        }

        $validator = Validator::make($data, $rules ?? []);
        $this->task->data = $validator->validated();

        return $this;
    }

    public function result()
    {
        return ($this->task)(...$this->arguments);
    }

    public function __destruct()
    {
        $this->result();
    }
}
