<?php

namespace EenmaalAndermaal\Model;

use EenmaalAndermaal\Request\ApiRequest;
use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Util\Collection;
use EenmaalAndermaal\Util\Debug;
use Iterator;

class ModelCollection implements Iterator
{

    /**
     * @var Collection
     */
    private $models;

    /**
     * @var Model $model
     */
    protected $model;

    private $position;

    public function __construct(Model $model)
    {
        $this->models = new Collection();
        $this->model = $model;
    }

    public function getAll()
    {
        $request = new ApiRequest($this->model->getPath(), RequestMethod::GET());
        if ($request->connect()) {
            foreach ($request->getResult() as $result) {
                $m = clone $this->model;
                $m->map($result);
                $this->models->add($m);
            }
            return true;
        } else {
            Debug::dump($request->getError());
            die();
        }
    }

    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current(): Model
    {
        return $this->models->get($this->position);
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return $this->position < $this->models->size();
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->position = 0;
    }
}