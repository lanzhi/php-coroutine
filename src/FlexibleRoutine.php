<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/19
 * Time: 下午2:47
 */

namespace lanzhi\coroutine;


use Generator;

class FlexibleRoutine extends AbstractRoutine
{
    /**
     * @var RoutineUnitInterface[]
     */
    private $units = [];

    public function add(RoutineUnitInterface $unit)
    {
        $this->units[$unit->getId()] = $unit;
        return $this;
    }

    /**
     * @return RoutineUnitInterface | null
     */
    public function remove(string $id)
    {
        if(isset($this->units[$id])){
            unset($this->units[$id]);
        }
    }

    protected function generate(): Generator
    {
        foreach ($this->units as $unit){
            $this->logger->info("run unit; name:{$unit->getName()}; id:{$unit->getId()}");
            yield from $unit();
        }
        if(isset($unit) && ($unit instanceof RoutineUnitInterface)){
            return $unit->getReturn();
        }
    }
}