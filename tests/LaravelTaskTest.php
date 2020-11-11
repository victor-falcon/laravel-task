<?php

namespace VictorFalcon\LaravelTask\Tests;

use VictorFalcon\LaravelTask\Facades\LaravelTask;
use VictorFalcon\LaravelTask\ServiceProvider;
use Orchestra\Testbench\TestCase;

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

    public function testExample()
    {
        $this->assertEquals(1, 1);
    }
}
