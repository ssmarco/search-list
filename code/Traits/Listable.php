<?php

namespace Marcz\Search\Traits;

trait Listable
{
    /**
     * Returns all the items in the list in an array.
     *
     * @return array
     */
    public function toArray()
    {
    }

    /**
     * Returns the contents of the list as an array of maps.
     *
     * @return array
     */
    public function toNestedArray()
    {
    }

    /**
     * Adds an item to the list, making no guarantees about where it will
     * appear.
     *
     * @param mixed $item
     */
    public function add($item)
    {
    }

    /**
     * Removes an item from the list.
     *
     * @param mixed $item
     */
    public function remove($item)
    {
    }

    /**
     * Returns the first item in the list.
     *
     * @return mixed
     */
    public function first()
    {
    }

    /**
     * Returns the last item in the list.
     *
     * @return mixed
     */
    public function last()
    {
    }

    /**
     * Returns a map of a key field to a value field of all the items in the
     * list.
     *
     * @param  string $keyfield
     * @param  string $titlefield
     * @return Map
     */
    public function map($keyfield = 'ID', $titlefield = 'Title')
    {
    }

    /**
     * Returns the first item in the list where the key field is equal to the
     * value.
     *
     * @param  string $key
     * @param  mixed $value
     * @return mixed
     */
    public function find($key, $value)
    {
    }

    /**
     * Returns an array of a single field value for all items in the list.
     *
     * @param  string $colName
     * @return array
     */
    public function column($colName = 'ID')
    {
    }

    /**
     * Walks the list using the specified callback
     *
     * @param callable $callback
     * @return $this
     */
    public function each($callback)
    {
    }

    /**
     * Return the number of items in this DataList
     *
     * @return int
     */
    public function count()
    {
    }

    public function offsetExists($offset)
    {
    }

    public function offsetGet($offset)
    {
    }

    public function offsetSet($offset, $value)
    {
    }

    public function offsetUnset($offset)
    {
    }
}
