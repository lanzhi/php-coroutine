<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/18
 * Time: 下午7:47
 */

namespace lanzhi\coroutine;


use Psr\Log\NullLogger;

abstract class AbstractRoutine implements RoutineInterface
{
    private $id;
    use RoutineUnitTrait;

    final public function toRoutine(): RoutineInterface
    {
        return $this;
    }

    final public function toRoutineUnit(): RoutineUnitInterface
    {
        return $this;
    }

    /**
     * AbstractRoutine constructor.
     * @param string $id
     */
    public function __construct(string $id=null)
    {
        $this->logger = $this->logger ?? new NullLogger();
        $this->id     = $id ?? get_called_class();
    }

    public function getId():string
    {
        return $this->id;
    }
}
