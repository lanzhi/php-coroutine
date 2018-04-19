<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/18
 * Time: 下午7:35
 */

namespace lanzhi\coroutine;


use Psr\Log\LoggerInterface;

interface RoutineInterface extends RoutineUnitInterface
{
    /**
     * @param string $name
     * @return RoutineInterface
     */
    public function setName(string $name);

    /**
     * @param LoggerInterface $logger
     * @return RoutineInterface
     */
    public function setLogger(LoggerInterface $logger);
}
