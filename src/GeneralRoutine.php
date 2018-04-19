<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/18
 * Time: 下午7:51
 */

namespace lanzhi\coroutine;


use Generator;

class GeneralRoutine extends AbstractRoutine
{
    /**
     * @var RoutineUnitInterface
     */
    private $unit;

    /**
     * GeneralRoutine constructor.
     * @param RoutineUnitInterface $unit
     * @param string|null $id
     */
    public function __construct(RoutineUnitInterface $unit, string $id=null)
    {
        $this->unit = $unit;
        parent::__construct($id);
    }

    protected function generate(): Generator
    {
        $unit = $this->unit;
        yield from $unit();
        if($unit->hasException()){
            throw $unit->getException();
        }
        return $unit->getReturn();
    }
}
