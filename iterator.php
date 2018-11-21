<?php
/**
 * rewind->valid->current->key
 * next->valid->current->key
 * next->valid
 */
class It implements Iterator
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function rewind()
    {
        echo __METHOD__;
        reset($this->data);
    }

    public function key()
    {
        echo __METHOD__;
        return key($this->data);
    }

    public function current()
    {
        echo __METHOD__;
        return current($this->data);
    }

    public function valid()
    {
        echo __METHOD__;
        return key($this->data) !== null;
    }

    public function next()
    {
        echo __METHOD__;
        next($this->data);
    }
}


$data = ['name' => 'm35', 'hello' => 'world'];
$it = new It($data);
foreach ($it as $key => $value) {
    echo "{$key} => {$value}\n";
}

$data = [1, 3, 5, 7, 9];
$it2 = new It($data);
foreach ($it2 as $key => $value) {
    echo "{$key} => {$value}\n";
}
