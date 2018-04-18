<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/2
 * Time: 下午9:02
 */

namespace lanzhi\coroutine;

use Psr\Log\LoggerInterface;


/**
 * Interface SchedulerInterface
 * @package lanzhi\coroutine\interfaces
 *
 *
 * 使用方法：
 * ```php
 *
 * $routine1 = new Routine1();
 * $routine2 = new Routine2();
 *
 * $scheduler = Scheduler::getInstance();
 * $scheduler->setLogger();
 * $scheduler->register($routine1);
 * $scheduler->register($routine2);
 * $scheduler->run();
 *
 * ```
 */
interface SchedulerInterface
{
    /**
     * @param RoutineInterface $unit
     */
    public function register(RoutineInterface $unit): self;

    /**
     * @return void
     */
    public function run(): void;

    /**
     * @param \Generator $generator
     * @return RoutineUnitInterface
     */
    public function buildRoutineUnit(\Generator $generator):RoutineUnitInterface;

    /**
     * @param \Generator $generator
     * @return RoutineInterface
     */
    public function buildRoutine(\Generator $generator):RoutineInterface;

    /**
     * @param LoggerInterface $logger
     * @return mixed
     */
    public function setLogger(LoggerInterface $logger);
}