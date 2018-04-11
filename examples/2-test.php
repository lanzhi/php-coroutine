<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/11
 * Time: 下午3:54
 */

include __DIR__."/../vendor/autoload.php";

use lanzhi\coroutine\AbstractTaskUnit;
use lanzhi\coroutine\Scheduler;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Logger\ConsoleLogger;

class Task1 extends AbstractTaskUnit
{
    protected function generate(): Generator
    {
        echo 'task1:start ', PHP_EOL;
        $return = (yield file_get_contents('http://www.weather.com.cn/data/cityinfo/101270101.html'));
        echo 'task1:end ', PHP_EOL;

        return $return;
    }
}

class Task2 extends AbstractTaskUnit
{
    protected function generate(): Generator
    {
        echo 'task2:start ', PHP_EOL;
        $return = (yield file_get_contents('https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=yourtoken'));
        echo 'task2:end ', PHP_EOL;

        return $return;
    }
}

class Task3 extends AbstractTaskUnit
{
    protected function generate(): Generator
    {
        $task1 = new Task1();
        yield from $task1();
        echo $task1->getReturn(), "\n";

        $task2 = new Task2();
        yield from $task2();
        echo $task2->getReturn(), "\n";
    }
}

$output = new ConsoleOutput(ConsoleOutput::VERBOSITY_DEBUG);
$logger = new ConsoleLogger($output);
$scheduler = new Scheduler($logger);

$startTime = microtime(true);

for($i=0; $i<50; $i++){
    $scheduler->register(new Task3());
}

$scheduler->run();

echo "time usage:", microtime(true)-$startTime, "\n";
