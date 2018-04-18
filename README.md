# php-coroutine

PHP 协程抽象工具

使用案例：
```php
include __DIR__."/../vendor/autoload.php";

use lanzhi\coroutine\AbstractRoutine;
use lanzhi\coroutine\Scheduler;

class Routine1 extends AbstractRoutine
{
    protected function generate() : Generator
    {
        yield;
        echo get_called_class() , ": step 1\n";

        yield;
        echo get_called_class(), ": step 2\n";

        yield;
        echo get_called_class(), ": step 3\n";

        return get_called_class() . ": return";
    }
}
class Routine2 extends AbstractRoutine
{
    protected function generate() : Generator
    {
        yield;
        echo get_called_class() , ": step 1\n";

        yield;
        echo get_called_class(), ": step 2\n";

        yield;
        echo get_called_class(), ": step 3\n";

        return get_called_class() . ": return";
    }
}

$scheduler = Scheduler::getInstance();

$scheduler->register(new Routine1());
$scheduler->register(new Routine2());

$scheduler->run();

```

Output：
```shell
Routine1: step 1
Routine2: step 1
Routine1: step 2
Routine2: step 2
Routine1: step 3
Routine2: step 3
```
