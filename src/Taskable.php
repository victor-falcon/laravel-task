<?php

declare(strict_types=1);

namespace VictorFalcon\LaravelTask;

trait Taskable
{
    public static function trigger(...$arguments): PendingTrigger
    {
        return new PendingTrigger(
            app()->make(self::class),
            $arguments
        );
    }
}
