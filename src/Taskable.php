<?php

declare(strict_types=1);

namespace VictorFalcon\LaravelTask;

trait Taskable
{
    public static function trigger(...$arguments)
    {
        $self = app()->make(self::class);

        return  ($self)(...$arguments);
    }
}
