<?php

namespace PEIP\Service;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * ServiceContainerBuilder
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP
 * @subpackage service
 * @extends \PEIP\Data\InternalStoreAbstract
 */




use PEIP\Factory\DedicatedFactory;

class ServiceContainerBuilder extends \PEIP\Data\InternalStoreAbstract
{
    /**
     * @param $key
     * @param $factory
     *
     * @return
     */
    public function setFactory($key, DedicatedFactory $factory)
    {
        $this->setInternalValue($key, $factory);
    }

    /**
     * @param $key
     *
     * @return
     */
    public function getFactory($key)
    {
        $this->getInternalValue($key);
    }

    /**
     * @param $key
     *
     * @return
     */
    public function hasFactory($key)
    {
        $this->hasInternalValue($key);
    }

    /**
     * @param $key
     *
     * @return
     */
    public function deleteFactory($key)
    {
        $this->deleteInternalValue($key);
    }

    /**
     * @param $key
     *
     * @return
     */
    public function getService($key)
    {
        return isset($this->services[$key]) ? $this->services[$key] : $this->services[$key] = $this->getFactory($key)->build();
    }

    /**
     * @param $key
     *
     * @return
     */
    public function buildService($key)
    {
        return $this->getFactory($key)->build();
    }
}
