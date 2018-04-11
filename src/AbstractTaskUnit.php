<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/2
 * Time: 下午9:03
 */

namespace lanzhi\coroutine;


use Generator;
use Throwable;

abstract class AbstractTaskUnit implements TaskUnitInterface
{
    private $isOver = false;
    private $returnValue;
    private $exception;

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
        $scheduler = new Scheduler();
        $scheduler->register($this);
        $scheduler->run();
    }

    final public function isOver():bool
    {
        return $this->isOver;
    }

    public function getReturn()
    {
        return $this->returnValue;
    }

    final public function getException():\Throwable
    {
        return $this->exception;
    }

    final public function hasException():bool
    {
        return (bool)$this->exception;
    }
}