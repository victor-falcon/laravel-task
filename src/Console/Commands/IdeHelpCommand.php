<?php

declare(strict_types=1);

namespace VictorFalcon\LaravelTask\Console\Commands;

use App\Models\User;
use Composer\Autoload\ClassMapGenerator;
use Illuminate\Console\Command;
use ReflectionClass;
use Symfony\Component\Console\Output\OutputInterface;
use VictorFalcon\LaravelTask\Task;
use Illuminate\Filesystem\Filesystem;

class IdeHelpCommand extends Command
{
    protected $name = 'task:ide-help';

    protected $description = 'Generate IDE help information for all tasks';

    protected Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle(): void
    {
        $filename = '_ide_helper_tasks.php';
        $content = $this->getContent();

        $written = $this->files->put($filename, $content);

        if ($written !== false) {
            $this->info("Model information was written to $filename");
        } else {
            $this->error("Failed to write model information to $filename");
        }
    }

    public function getContent(): string
    {
        $output = "<?php
// @formatter:off
/**
 * A helper file for your Laravel Tasks
 *
 * @author Víctor Falcón <hi@victorfalcon.es>
 */
\n\n";

        foreach ($this->getTasks() as $taskName) {
            if (!class_exists($taskName)) {
                continue;
            }

            $reflectionClass = new ReflectionClass($taskName);

            if (!$reflectionClass->isSubclassOf(Task::class) || !$reflectionClass->IsInstantiable()) {
                continue;
            }

            $this->comment("Loading task '$taskName'", OutputInterface::VERBOSITY_VERBOSE);

            $task = $this->getLaravel()->make($taskName);
            $constructorReflection = $reflectionClass->getConstructor();
            $handleReflection = new \ReflectionMethod($task, 'handle');

            if ($constructorReflection !== null) {
                $args = $this->getParameters($constructorReflection);
                $returnType = $this->getReturnType($handleReflection);

                $output .= $this->createPhpDocs($task, $args, $returnType);
            }
        }

        return $output;
    }

    private function getTasks(): array
    {
        $tasks = [];

        foreach (config('laravel-task.folders', ['app/Tasks']) as $folder) {
            if (is_dir(base_path($folder))) {
                $folder = base_path($folder);
            }

            $folders = glob($folder, GLOB_ONLYDIR);

            foreach ($folders as $dir) {
                if (!is_dir($dir)) {
                    $this->error("Cannot locate directory '{'$dir}'");
                    continue;
                }

                if (file_exists($dir)) {
                    $classMap = ClassMapGenerator::createMap($dir);

                    // Sort list so it's stable across different environments
                    ksort($classMap);

                    foreach ($classMap as $task => $path) {
                        $tasks[] = $task;
                    }
                }
            }
        }

        return $tasks;
    }

    private function getParameters(\ReflectionMethod $method): array
    {
        $paramsWithDefault = [];

        /** @var \ReflectionParameter $param */
        foreach ($method->getParameters() as $param) {
            $paramClass = $param->getClass();
            $paramType = $param->getType();

            if ($paramClass !== null) {
                $paramStr = '\\'.$paramClass->getName().' $'.$param->getName();
            } elseif ($paramType !== null) {
                $paramStr = $paramType->getName().' $'.$param->getName();
            } else {
                $paramStr = '$'.$param->getName();
            }

            if ($param->isOptional() && $param->isDefaultValueAvailable()) {
                $default = $param->getDefaultValue();
                if (is_bool($default)) {
                    $default = $default ? 'true' : 'false';
                } elseif (is_array($default)) {
                    $default = '[]';
                } elseif (is_null($default)) {
                    $default = 'null';
                } else {
                    $default = "'".trim($default)."'";
                }
                $paramStr .= " = $default";
            }

            $paramsWithDefault[] = $paramStr;
        }

        return $paramsWithDefault;
    }

    private function getReturnType(\ReflectionMethod $method)
    {
        $r = $method->getReturnType();

        return sprintf(
            '%s%s%s',
            $r->allowsNull() ? '?' : '',
            $r->isBuiltin() ? '' : '\\',
            $r->getName(),
        );
    }

    private function createPhpDocs(Task $task, array $args, string $return): string
    {
        $reflection = new ReflectionClass($task);
        $namespace = $reflection->getNamespaceName();
        $classname = $reflection->getShortName();
        $argsString = implode(', ', $args);

        $user = '\\' . User::class;

        return <<<TEXT

namespace $namespace {
    /**
     * @method static self trigger($argsString)
     * @method self by($user \$user)
     * @method self withValid(array \$data)
     * @method $return result
     * @method $return forceResult
     */
    class $classname extends \VictorFalcon\LaravelTask\Task {}
}
TEXT;
    }
}
