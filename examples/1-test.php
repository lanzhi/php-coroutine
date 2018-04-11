<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/11
 * Time: 下午1:09
 */

include __DIR__."/../vendor/autoload.php";

use lanzhi\coroutine\AbstractTaskUnit;
use lanzhi\coroutine\Scheduler;

class Task1 extends AbstractTaskUnit
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
class Task2 extends AbstractTaskUnit
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
class Task3 extends AbstractTaskUnit
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

class Task4 extends AbstractTaskUnit
{
    protected function generate() : Generator
    {
        yield;
        echo get_called_class() , ": step 1\n";

        yield;
        echo get_called_class(), ": step 2\n";

        throw new \Exception("test throw exception");
    }
}

class Task5 extends AbstractTaskUnit
{
    protected function generate(): Generator
    {
        $task = new Task4();
        yield from $task(false);

        if($task->isOver() && $task->getException()){
            var_dump($task->getException()->getMessage());
        }else{
            var_dump($task->getReturn());
        }

        yield;
        echo get_called_class() , ": step 2\n";
    }
}

$scheduler = new Scheduler();
$scheduler->register(new Task1());
$scheduler->register(new Task2());
$scheduler->register(new Task3());
$scheduler->register(new Task5());

$scheduler->run();
