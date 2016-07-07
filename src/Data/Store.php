<?php

namespace PEIP\Data;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Store
 * A simple class to act as a store for arbritrary values.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @extends \PEIP\Data\ArrayAccess
 * @implements ArrayAccess, \PEIP\INF\Data\Store
 */
class Store extends \PEIP\Data\ArrayAccess implements \PEIP\INF\Data\Store
{
    /**
     * Sets a value for a given key.
     *
     * @param mixed $key   the key to store value for
     * @param mixed $value the value to store
     *
     * @return
     */
    public function setValue($key, $value)
    {
        return $this->offsetSet($key, $value);
    }

    /**
     * returns the value for a given key.
     *
     * @param mixed $key the key to return value for
     *
     * @return mixed the value for the given key
     */
    public function getValue($key)
    {
        return $this->offsetGet($key, $value);
    }

    /**
     * Unsets the value for a given key.
     *
     * @param mixed $key the key to unset value for
     *
     * @return
     */
    public function deleteValue($key)
    {
        return $this->offsetUnset($key);
    }

    /**
     * Checks wether a value is stored for given key.
     *
     * @param mixed $key the key to look for a value
     *
     * @return bool wether a value is stored for the key
     */
    public function hasValue($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * Sets all values for the store as key/value pair array.
     *
     * @param array $values key/value pairs to store
     *
     * @return
     */
    public function setValues(array $values)
    {
        $this->values = $values;
    }

    /**
     * returns all values for the store as key/value pairs.
     *
     * @return array stored key/value pairs
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Adds values for the store as key/value pair array.
     * Overwrites value for a key if allready has been set.
     *
     * @param $values
     *
     * @return
     */
    public function addValues(array $values)
    {
        array_merge($this->values, $values);
    }
}
