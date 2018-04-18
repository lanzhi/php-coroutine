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
     * @var Generator
     */
    private $generator;

    /**
     * GeneralRoutine constructor.
     * @param Generator $generator
     * @param int | string $id
     */
    public function __construct(Generator $generator, $id=null)
    {
        $this->generator = $generator;
        parent::__construct($id);
    }

    protected function generate(): Generator
    {
        return $this->generator;
    }
}