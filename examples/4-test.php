<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/19
 * Time: 上午11:37
 */

include __DIR__."/../vendor/autoload.php";

use lanzhi\coroutine\AbstractRoutine;
use lanzhi\coroutine\Scheduler;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Logger\ConsoleLogger;

$output = new ConsoleOutput(ConsoleOutput::VERBOSITY_DEBUG);
$logger = new ConsoleLogger($output);

$scheduler = Scheduler::getInstance()->setLogger($logger);

function generate() : Generator
{
    yield;
    echo __LINE__, ": step 1\n";

    yield;
    echo __LINE__, ": step 2\n";

    yield;
    echo __LINE__, ": step 3\n";

    return __LINE__ . ": return";
}

$scheduler->registerAsRoutine(generate());

$scheduler->run();
