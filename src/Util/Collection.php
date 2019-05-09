<?php

namespace EenmaalAndermaal\Util;

class Collection
{

    /** @var object[] $list */
    protected $list = [];

    public function add($object)
    {
        $this->list[] = $object;
        return $this;
    }

    public function clear()
    {
        $this->list = [];
    }

    public function size(): int
    {
        return count($this->list);
    }

    public function remove(int $index)
    {
        unset($this->list[$index]);
        $this->list = array_values($this->list);
    }

    public function get(int $index)
    {
        return $this->list[$index];
    }
}