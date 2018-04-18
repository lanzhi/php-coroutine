<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/11
 * Time: 下午1:09
 */

include __DIR__."/../vendor/autoload.php";

use lanzhi\coroutine\AbstractRoutine;
use lanzhi\coroutine\Scheduler;

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
class Routine3 extends AbstractRoutine
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

class Routine4 extends AbstractRoutine
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

class Routine5 extends AbstractRoutine
{
    protected function generate(): Generator
    {
        $Routine = new Routine4();
        yield from $Routine(false);

        if($Routine->isOver() && $Routine->getException()){
            var_dump($Routine->getException()->getMessage());
        }else{
            var_dump($Routine->getReturn());
        }

        yield;
        echo get_called_class() , ": step 2\n";
    }
}

$scheduler = Scheduler::getInstance();

$scheduler->register(new Routine1(null));
$scheduler->register(new Routine2(null));
$scheduler->register(new Routine3());
$scheduler->register(new Routine5());

$scheduler->run();
