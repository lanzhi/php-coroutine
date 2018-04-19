<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/2
 * Time: 下午9:03
 */

namespace lanzhi\coroutine;


use Psr\Log\NullLogger;

abstract class AbstractRoutineUnit implements RoutineUnitInterface
{
    use RoutineUnitTrait;

    /**
     * AbstractTaskUnit constructor.
     */
    public function __construct()
    {
        $this->logger = $this->logger ?? new NullLogger();
    }

    final public function toRoutine(): RoutineInterface
    {
        return new GeneralRoutine($this, 'built-from-routine-unit#'.uniqid());
    }

    final public function toRoutineUnit(): RoutineUnitInterface
    {
        return $this;
    }
}
