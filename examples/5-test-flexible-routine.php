<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/19
 * Time: 下午2:55
 */

include __DIR__."/../vendor/autoload.php";

use lanzhi\coroutine\AbstractRoutine;
use lanzhi\coroutine\Scheduler;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Logger\ConsoleLogger;


class Routine1 extends AbstractRoutine
{
    protected function generate() : Generator
    {
        yield;
        echo get_called_class() , ": step 1\n";

        yield;
        echo get_called_class(), ": step 2\n";

        yield;
        echo get_called_class(), ": step 3\n";

        return get_called_class() . ": return";
    }
}
class Routine2 extends AbstractRoutine
{
    protected function generate() : Generator
    {
        yield;
        echo get_called_class() , ": step 1\n";

        yield;
        echo get_called_class(), ": step 2\n";

        yield;
        echo get_called_class(), ": step 3\n";

        return get_called_class() . ": return";
    }
}

$output = new ConsoleOutput(ConsoleOutput::VERBOSITY_DEBUG);
$logger = new ConsoleLogger($output);
$scheduler = Scheduler::getInstance()->setLogger($logger);

$routine = new \lanzhi\coroutine\FlexibleRoutine();
$routine->setLogger($logger);
$routine->append(new Routine1());
$routine->append(new Routine1());
$scheduler->register($routine);

$routine = new \lanzhi\coroutine\FlexibleRoutine();
$routine->setLogger($logger);
$routine->append(new Routine2());
$routine->append(new Routine2());
$scheduler->register($routine);

$scheduler->run();
