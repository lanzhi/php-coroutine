<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/2
 * Time: 下午9:03
 */

namespace lanzhi\coroutine;


use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

abstract class AbstractUnit implements RoutineUnitInterface
{
    use RoutineUnitTrait;

    /**
     * AbstractTaskUnit constructor.
     * @param LoggerInterface|null $logger
     */
    public function __construct()
    {
        $this->logger = new NullLogger();
    }

    final public function toRoutine(): RoutineInterface
    {
        return new GeneralRoutine($this->generate(), 'built-from-routine-unit');
    }
}
