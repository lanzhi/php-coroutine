<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/18
 * Time: 下午7:40
 */

namespace lanzhi\coroutine;

use Generator;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Throwable;

trait RoutineUnitTrait
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    private $isOver = false;
    private $returnValue;
    private $exception;

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    abstract protected function generate(): Generator;

    final public function __invoke(bool $throwable=true): Generator
    {
        try{
            $gen =  $this->generate();
            yield from $gen;
            $this->returnValue = $gen->getReturn();
        }catch (Throwable $exception){
            if($throwable){
                throw $exception;
            }else{
                $this->exception = $exception;
            }
            yield;
        }

        $this->isOver = true;
    }

    final public function run()
    {
        Scheduler::getInstance()->register($this->toRoutine())->run();
    }

    final public function isOver():bool
    {
        return $this->isOver;
    }

    final public function getException():\Throwable
    {
        return $this->exception;
    }

    final public function hasException():bool
    {
        return (bool)$this->exception;
    }

    public function getReturn()
    {
        return $this->returnValue;
    }
}
