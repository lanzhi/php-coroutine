<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/2
 * Time: 下午9:02
 */

namespace lanzhi\coroutine;


use Generator;
use Ds\Queue;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Scheduler
{
    /**
     * @var Queue
     */
    private $queue;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var static
     */
    private static $instance;

    public static function getInstance():self
    {
        if(!self::$instance){
            self::$instance = new static();
        }

        return self::$instance;
    }

    public static function buildRoutineUnit(Generator $generator):RoutineUnitInterface
    {
        return new GeneralRoutineUnit($generator);
    }

    public static function buildRoutine(Generator $generator):RoutineInterface
    {
        return (new GeneralRoutineUnit($generator))->toRoutine();
    }

    protected function __construct()
    {
        $this->queue  = new Queue();
        $this->logger = new NullLogger();
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @param RoutineInterface $routine
     * @return self
     */
    public function register(RoutineInterface $routine): self
    {
        $this->logger->info("register one routine; type:{type}; id:{id}", [
            'type' => get_class($routine),
            'id'   => $routine->getId()
        ]);

        $this->queue->push($routine());
        return $this;
    }

    public function registerAsRoutine(Generator $generator): self
    {
        return $this->register(self::buildRoutine($generator));
    }

    /**
     * @param RoutineInterface[] $routines
     */
    public function batchRegister(array $routines): self
    {
        foreach ($routines as $routine){
            $this->register($routine);
        }
        return $this;
    }

    public function run(): void
    {
        while(!$this->queue->isEmpty()){
            /**
             * @var Generator $generator
             */
            $generator = $this->queue->pop();

            $this->timer('current');
            $value = $generator->current();
            $this->logger->debug("tick current; time usage:".$this->timer('current'));

            $this->timer('send');
            $generator->send($value);
            $this->logger->debug("tick send; time usage:".$this->timer('send'));

            if($generator->valid()){
                $this->queue->push($generator);
            }
        }
    }

    private function timer(string $mark)
    {
        static $list = [];
        if(empty($list[$mark])){
            $list[$mark] = microtime(true);
            return 0;
        }else{
            $startTime = $list[$mark];
            $list[$mark] = microtime(true);
            return round($list[$mark] - $startTime, 6);
        }
    }
}
