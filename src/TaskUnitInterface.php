<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/2
 * Time: 下午9:01
 */

namespace lanzhi\coroutine;


use Generator;
use Throwable;

/**
 * Interface TaskUnitInterface
 * @package lanzhi\coroutine\interfaces
 *
 *
 * TaskUnit 只能在调度器内或者其它 TaskUnit 内使用
 * 使用方法如下:
 * ```php
 *
 * $task = new TaskUnit();
 * yield from $task();
 * $returnValue = $task->getReturn();
 *
 * ```
 * 或者如下：
 * ```php
 *
 * $task = new TaskUnit();
 * yield from $task(false);
 * if(!$task->hasException()){
 *     $returnValue = $task->getReturn();
 * }else{
 *     $exception = $task->getException();
 * }
 *
 * ```
 */
interface TaskUnitInterface
{
    /**
     *
     * @param bool $throwable
     * @return Generator
     */
    public function __invoke(bool $throwable=true): Generator;

    /**
     * 不经注册调度器直接执行
     * @return mixed
     */
    public function run();

    /**
     * 当前任务单元执行完毕时返回true，否则返回false
     * @return bool
     */
    public function isOver(): bool;

    /**
     * 配合其它方法使用才有意义
     * 在当前任务执行完毕且没有异常情况下，返回任务单元执行结果，根据具体情况可能是 null
     * 任务没有开始执行、执行中、执行异常均返回 null
     * @return mixed
     */
    public function getReturn();

    /**
     * 当且仅当任务执行过程中抛出异常且调度本任务单元时特意设置不允许抛出异常时返回 true
     * 当返回值为 true 时，调用 getException() 必须能够获取到相应异常类
     * @return bool
     */
    public function hasException(): bool;

    /**
     * @return Throwable
     */
    public function getException(): Throwable;
}
