<?php
/**
 * Created by PhpStorm.
 * User: lanzhi
 * Date: 2018/4/2
 * Time: 下午9:03
 */

namespace lanzhi\coroutine;

use Generator;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Throwable;

abstract class AbstractRoutineUnit implements RoutineUnitInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;
    private $id;
    private $name;
    private $isOver = false;
    private $returnValue;
    private $exception;

    private $createTime;
    private $startRunTime;
    private $endRunTime;

    public function __construct()
    {
        $this->id         = uniqid();
        $this->name       = get_called_class();
        $this->logger     = $this->logger ?? new NullLogger();

        $this->createTime = microtime(true);
    }

    public function getId():string
    {
        return $this->id;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    abstract protected function generate(): Generator;

    final public function __invoke(bool $throwable=true): Generator
    {
        $this->startRunTime = microtime(true);
        try{
            $gen =  $this->generate();
            yield from $gen;
            $this->returnValue = $gen->getReturn();
        }catch (Throwable $exception){
            if($throwable){
                throw $exception;
            }else{
                $this->exception = $exception;
            }
            yield;
        }

        $this->startRunTime = microtime(true);
        $this->isOver = true;
    }

    final public function run()
    {
        Scheduler::getInstance()->register($this->toRoutine())->run();
    }

    final public function isOver():bool
    {
        return $this->isOver;
    }

    final public function getException():\Throwable
    {
        return $this->exception;
    }

    final public function hasException():bool
    {
        return (bool)$this->exception;
    }

    public function getReturn()
    {
        return $this->returnValue;
    }

    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMetaInfo(): array
    {
        $info = [
            'name'        => $this->name,
            'createTime'  => $this->createTime,
            'startRunTime'=> $this->startRunTime,
            'endRunTime'  => $this->endRunTime,
        ];
        if(isset($this->id)){
            $info['id'] = $this->id;
        }

        return $info;
    }

    public function toRoutine(): RoutineInterface
    {
        return (new GeneralRoutine($this))->setName($this->getName().'#built-from-unit');
    }

    public function toRoutineUnit(): RoutineUnitInterface
    {
        return $this;
    }
}
