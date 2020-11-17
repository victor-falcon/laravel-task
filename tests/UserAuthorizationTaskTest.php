<?php

declare(strict_types=1);

namespace VictorFalcon\LaravelTask\Tests;

use Illuminate\Auth\Access\AuthorizationException;
use Orchestra\Testbench\TestCase;
use VictorFalcon\LaravelTask\Tests\stub\NotAuthorizedTask;

class UserAuthorizationTaskTest extends TestCase
{
    public function testErrorThrownWhenNotAuthorized()
    {
        $this->expectException(AuthorizationException::class);
        $this->expectExceptionMessage('You are unauthorized to trigger this action');

        NotAuthorizedTask::trigger();
    }

    public function testThatForceResultDontTriggerAuthorization()
    {
        $result = NotAuthorizedTask::trigger()->forceResult();
        self::assertTrue($result);
    }
}
