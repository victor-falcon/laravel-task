<?php

namespace VictorFalcon\LaravelTask\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeTaskCommand extends GeneratorCommand
{
    protected $name = 'make:task';

    protected $description = 'Create a new task class';

    protected function getStub()
    {
        return __DIR__ . '/../../stub/model.stub';
    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $default = config('laravel-task.folders', 'app/Tasks');
        if (is_array($default)) {
            $default = $default[0];
        }

        $default = Str::replaceFirst('app/', '', $default);

        return is_dir(app_path($default)) ? $rootNamespace.'\\'.$default : $rootNamespace;
    }
}
