<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/5/3
 * Time: 下午8:42
 */


include __DIR__."/../vendor/autoload.php";

use lanzhi\coroutine\AbstractRoutine;
use lanzhi\coroutine\Scheduler;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Logger\ConsoleLogger;


$output = new ConsoleOutput(ConsoleOutput::VERBOSITY_DEBUG);
$logger = new ConsoleLogger($output);
$scheduler = Scheduler::getInstance()->setLogger($logger);

echo "#test register as routine\n";
$scheduler->registerAsRoutine(function() : Generator
{
    yield;
    echo __LINE__, ": step 1\n";

    yield;
    echo __LINE__, ": step 2\n";

    yield;
    echo __LINE__, ": step 3\n";

    return __LINE__ . ": return";
});
$scheduler->run();

echo "#test build routine unit\n";
$routineUnit = Scheduler::buildRoutineUnit(function(){
    yield;
    echo __LINE__, ": step 1\n";

    yield;
    echo __LINE__, ": step 2\n";
});
$routineUnit->run();

echo "#test build routine\n";
$routine = Scheduler::buildRoutine(function (){
    yield;
    echo __LINE__, ": step 1\n";

    yield;
    echo __LINE__, ": step 2\n";
});
$routine->run();
