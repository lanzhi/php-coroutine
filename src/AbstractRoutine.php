<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/18
 * Time: 下午7:47
 */

namespace lanzhi\coroutine;


abstract class AbstractRoutine extends AbstractRoutineUnit implements RoutineInterface
{

    public function toRoutine(): RoutineInterface
    {
        return $this;
    }

}
