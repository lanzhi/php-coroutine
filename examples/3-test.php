<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/11
 * Time: 下午3:54
 */

include __DIR__."/../vendor/autoload.php";

use lanzhi\coroutine\AbstractRoutine;
use lanzhi\coroutine\Scheduler;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Logger\ConsoleLogger;

class Routine1 extends AbstractRoutine
{
    protected function generate(): Generator
    {
        echo 'Routine1:start ', PHP_EOL;
        $return = (yield file_get_contents('http://www.weather.com.cn/data/cityinfo/101270101.html'));
        echo 'Routine1:end ', PHP_EOL;

        return $return;
    }
}

class Routine2 extends AbstractRoutine
{
    protected function generate(): Generator
    {
        echo 'Routine2:start ', PHP_EOL;
        $return = (yield file_get_contents('https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=yourtoken'));
        echo 'Routine2:end ', PHP_EOL;

        return $return;
    }
}

class Routine3 extends AbstractRoutine
{
    protected function generate(): Generator
    {
        $Routine1 = new Routine1();
        yield from $Routine1();
        echo $Routine1->getReturn(), "\n";

        $Routine2 = new Routine2();
        yield from $Routine2();
        echo $Routine2->getReturn(), "\n";
    }
}

$output = new ConsoleOutput(ConsoleOutput::VERBOSITY_DEBUG);
$logger = new ConsoleLogger($output);
$scheduler = Scheduler::getInstance()->setLogger($logger);

$startTime = microtime(true);

for($i=0; $i<2; $i++){
    echo "===================================\n";
    (new Routine3())->run();
}

echo "time usage:", microtime(true)-$startTime, "\n";
