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
 * ParameterCollection.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @extends \PEIP\Data\ParameterHolder
 * @implements \PEIP\INF\Data\ParameterHolder, ArrayAccess
 */
class ParameterCollection extends \PEIP\Data\ParameterHolder implements \ArrayAccess
{
    /**
     * @param $offset
     *
     * @return
     */
    public function offsetExists($offset)
    {
        return $this->hasParameter($offset);
    }

    /**
     * @param $offset
     *
     * @return
     */
    public function offsetGet($offset)
    {
        return $this->getParameter($offset);
    }

    /**
     * @param $name
     *
     * @return
     */
    public function offsetUnset($name)
    {
        $this->deleteParameter($name);
    }

    /**
     * @param $offset
     * @param $name
     *
     * @return
     */
    public function offsetSet($offset, $name)
    {
        $this->setParameter($offeset, $name);
    }
}
