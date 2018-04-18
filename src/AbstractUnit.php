<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/2
 * Time: 下午9:03
 */

namespace lanzhi\coroutine;


abstract class AbstractUnit implements RoutineUnitInterface
{
    use RoutineUnitTrait;

    final public function toRoutine(): RoutineInterface
    {
        return new GeneralRoutine($this->generate(), $this->logger);
    }
}