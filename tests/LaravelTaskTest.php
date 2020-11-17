<?php

namespace VictorFalcon\LaravelTask\Tests;

use Illuminate\Validation\ValidationException;
use VictorFalcon\LaravelTask\Facades\LaravelTask;
use VictorFalcon\LaravelTask\ServiceProvider;
use Orchestra\Testbench\TestCase;
use VictorFalcon\LaravelTask\Tests\stub\BasicTask;
use VictorFalcon\LaravelTask\Tests\stub\ThrowableTask;
use VictorFalcon\LaravelTask\Tests\stub\ValidationTask;

class LaravelTaskTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'laravel-task' => LaravelTask::class,
        ];
    }

    public function testBasicTaskTrigger()
    {
        $input = random_int(0, 1) === 0;

        $result = BasicTask::trigger($input)->result();

        self::assertEquals($input, $result);
    }

    public function testTaskWithValidation()
    {
        $response =  ValidationTask::trigger()
            ->withValidation([
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
            ->withValidation([
                'name' => '12',
            ])
            ->result();
    }

    public function testTaskIsTriggerWhenNoResponseNeeded()
    {
        $this->expectExceptionMessage('Task trigger');

        ThrowableTask::trigger();
    }
}
