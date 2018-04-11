<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/2
 * Time: 下午9:02
 */

namespace lanzhi\coroutine;


/**
 * Interface SchedulerInterface
 * @package lanzhi\coroutine\interfaces
 *
 *
 * 使用方法：
 * ```php
 *
 * $task1 = new TaskUnit1();
 * $task2 = new TaskUnit2();
 *
 * $scheduler = new Scheduler();
 * $scheduler->register($task1);
 * $scheduler->register($task2);
 * $scheduler->run();
 *
 * ```
 */
interface SchedulerInterface
{
    /**
     * @param TaskUnitInterface $unit
     */
    public function register(TaskUnitInterface $unit): void;

    /**
     * @return void
     */
    public function run(): void;
}