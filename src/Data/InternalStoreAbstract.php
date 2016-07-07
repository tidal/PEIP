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
 * InternalStoreAbstract.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 */

abstract class InternalStoreAbstract
{
    private $internalValues = [];

    /**
     * @param $key
     *
     * @return
     */
    protected function hasInternalValue($key)
    {
        return array_key_exists($key, $this->internalValues);
    }

    /**
     * @param $key
     *
     * @return
     */
    protected function getInternalValue($key)
    {
        return array_key_exists($key, $this->internalValues) ? $this->internalValues[$key] : null;
    }

    /**
     * @param $key
     *
     * @return
     */
    protected function deleteInternalValue($key)
    {
        unset($this->internalValues[$key]);
    }

    /**
     * @param $key
     * @param $value
     *
     * @return
     */
    protected function setInternalValue($key, $value)
    {
        $this->internalValues[$key] = $value;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return
     */

    /**
     * @param $internalValues
     *
     * @return
     */
    protected function setInternalValues(array $internalValues)
    {
        $this->internalValues = $internalValues;
    }

    /**
     * @param $key
     *
     * @return
     */

    /**
     * @return
     */
    protected function getInternalValues()
    {
        return $this->internalValues;
    }

    /**
     * @return
     */
    protected function addInternalValues()
    {
        array_merge($this->internalValues, $internalValues);
    }
}
