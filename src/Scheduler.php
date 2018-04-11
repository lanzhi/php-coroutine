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

class Scheduler implements SchedulerInterface
{
    /**
     * @var Queue
     */
    private $queue;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger=null)
    {
        $this->queue = new Queue();
        $this->logger = $logger ?? new NullLogger();
    }

    /**
     * @param TaskUnitInterface $unit
     */
    public function register(TaskUnitInterface $unit): void
    {
        $this->logger->info("register one Task Unit; type:{type}", [
            'type' => get_class($unit)
        ]);

        $this->queue->push($unit());
    }

    /**
     * @param TaskUnitInterface[] $units
     */
    public function batchRegister(array $units)
    {
        foreach ($units as $unit){
            $this->register($unit);
        }
    }

    public function run(): void
    {
        while(!$this->queue->isEmpty()){
            /**
             * @var Generator $generator
             */
            $generator = $this->queue->pop();
            $generator->next();

            if($generator->valid()){
                $this->queue->push($generator);
            }
        }
    }
}