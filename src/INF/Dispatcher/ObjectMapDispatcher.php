<?php

namespace PEIP\INF\Dispatcher;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Dispatcher\ObjectMapDispatcher.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 */
interface ObjectMapDispatcher
{
    public function connect($name, $object, $listener);

    public function disconnect($name, $object, $listener);

    public function hasListeners($name, $object);

    public function getEventNames($object);

    public function notify($name, $object);

    public function getListeners($name, $object);
}
