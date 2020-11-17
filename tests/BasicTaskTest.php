<?php

namespace VictorFalcon\LaravelTask\Tests;

use Illuminate\Validation\ValidationException;
use VictorFalcon\LaravelTask\ServiceProvider;
use Orchestra\Testbench\TestCase;
use VictorFalcon\LaravelTask\Tests\stub\BasicTask;
use VictorFalcon\LaravelTask\Tests\stub\ThrowableTask;
use VictorFalcon\LaravelTask\Tests\stub\ValidationTask;

class BasicTaskTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    public function testBasicTaskTrigger()
    {
        $input = random_int(0, 1) === 0;

        $result = BasicTask::trigger($input)->result();

        self::assertEquals($input, $result);
    }

    public function testTaskIsTriggerWhenNoResponseNeeded()
    {
        $this->expectExceptionMessage('Task trigger');

        ThrowableTask::trigger();
    }
}
