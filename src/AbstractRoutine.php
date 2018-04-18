<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/18
 * Time: 下午7:47
 */

namespace lanzhi\coroutine;


abstract class AbstractRoutine implements RoutineInterface
{
    use RoutineUnitTrait;

    final public function toRoutine(): RoutineInterface
    {
        return $this;
    }
}