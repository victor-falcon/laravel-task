<?php

declare(strict_types=1);

namespace VictorFalcon\LaravelTask\Tests;

use Illuminate\Validation\ValidationException;
use Orchestra\Testbench\TestCase;
use VictorFalcon\LaravelTask\ServiceProvider;
use VictorFalcon\LaravelTask\Tests\stub\ValidationTask;
use VictorFalcon\LaravelTask\Tests\stub\WrongValidationTask;

class ValidationTaskTest extends TestCase
{
    public function testTaskWithValidation()
    {
        $response =  ValidationTask::trigger()
            ->withValid([
                'name' => '123',
                'random_data' => true,
            ])
            ->result();

        self::assertEquals(['name' => '123'], $response);
    }

    public function testTaskWithValidationTriggerErrors()
    {
        $this->expectException(ValidationException::class);

        ValidationTask::trigger()
            ->withValid([
                'name' => '12',
            ])
            ->result();
    }

    public function testItThrowsAnErrorWhenThereAreSomeError(): void
    {
        $this->expectExceptionMessage('Method Illuminate\Validation\Validator::validateInvalidaValidationRule does not exist.');

        WrongValidationTask::trigger()->withValid(['name' => 'Jhon Doe']);
    }
}
