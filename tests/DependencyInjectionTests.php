<?php

declare(strict_types=1);

namespace VictorFalcon\LaravelTask\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Orchestra\Testbench\TestCase;
use VictorFalcon\LaravelTask\ServiceProvider;
use VictorFalcon\LaravelTask\Tests\stub\DependencyTask;

class DependencyInjectionTests extends TestCase
{
    use WithFaker;

    public function testClassDependencyInjection()
    {
        $input = $this->faker->name;

        $result = DependencyTask::trigger($input)->result();

        self::assertEquals($input, $result);
    }
}
