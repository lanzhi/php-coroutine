<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/18
 * Time: 下午7:29
 */

namespace lanzhi\coroutine;


use Generator;

class GeneralUnit extends AbstractUnit
{
    /**
     * @var Generator
     */
    private $generator;

    public function __construct(Generator $generator, $logger = null)
    {
        $this->generator = $generator;
        parent::__construct($logger);
    }

    protected function generate(): Generator
    {
        return $this->generator;
    }
}