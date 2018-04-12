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
use React\EventLoop\Factory;
use React\HttpClient\Client;
use React\HttpClient\Response;


class AsyncComponent
{

}

class HttpRequestTask extends AbstractTaskUnit
{
    private $id;
    private $url;

    /**
     * HttpRequestTask constructor.
     * @param string $id
     * @param string $url
     */
    public function __construct($id, $url)
    {
        $this->id = $id;
        $this->url = $url;
        parent::__construct(null);
    }

    public function generate(): Generator
    {
        $loop = Factory::create();

        $client = new Client($loop);

        $request = $client->request('GET', $this->url);

        $buffer = '';
        $i = $this->id;
        $isRunning = true;

        $request->on('response', function (Response $response) use($i, &$isRunning, &$buffer){
            $response->on('data', function ($data) use (&$buffer, $i) {
                $buffer .= $data;
            });

            $response->on('end', function () use (&$buffer, $i, &$isRunning, $response) {
                echo "#$i response length:", strlen($buffer), " response code:{$response->getCode()} response reason:{$response->getReasonPhrase()}\n";

                $isRunning = false;
            });
        });
        $request->end();

        while($isRunning){
            yield;
            $loop->tick();
        }

        return $buffer;
    }
}

class Task3 extends AbstractTaskUnit
{
    protected function generate(): Generator
    {
        $list = [
            'github'=> 'https://github.com/lanzhi/tcpcopy',
            'php'   => 'http://php.net/manual/en/sockets.constants.php',
            'packagist'=> 'https://packagist.org/packages/clue/buzz-react',
            'http'     => 'https://mdref.m6w6.name/http'
        ];

        foreach ($list as $id=>$url){
            $task = new HttpRequestTask($id, $url);
            yield from $task();
//            echo $task->getReturn(), "\n";
        }
    }
}

$output = new ConsoleOutput(ConsoleOutput::VERBOSITY_DEBUG);
$logger = new ConsoleLogger($output);
$scheduler = new Scheduler(null);

$startTime = microtime(true);

for($i=0; $i<50; $i++){
    $scheduler->register(new Task3());
}

$scheduler->run();

echo "time usage:", microtime(true)-$startTime, "\n";
