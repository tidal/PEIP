<?php

namespace PEIP\ABS\Dispatcher;

namespace PEIP\ABS\Dispatcher;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * PEIP\ABS\Dispatcher\MapDispatcher
 * Abstract base class for namespaced dispatcher.
 * Derived concrete classes can be used (for example) as event dispatchers.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP
 * @subpackage dispatcher
 * @extends \PEIP\ABS\Dispatcher\Dispatcher
 * @implements \PEIP\INF\Event\Connectable
 */

use PEIP\Util\Test;

abstract class MapDispatcher extends \PEIP\ABS\Dispatcher\Dispatcher implements //PEIP\INF\Dispatcher\MapDispatcher,
        \PEIP\INF\Event\Connectable
{
    protected $listeners = [];

    /**
     * Connects a listener to a given event-name.
     *
     * @param string                            $name     name of the event
     * @param callable|PEIP\INF\Handler\Handler $listener listener to connect
     *
     * @return
     */
    public function connect($name, $listener)
    {
        Test::ensureHandler($listener);
        if (!$this->hasListeners($name)) {
            $this->listeners[$name] = [];
        }
        $this->listeners[$name][] = $listener;

        return true;
    }

    /**
     * Disconnects a listener from a given event-name.
     *
     * @param string                            $name     name of the event
     * @param callable|PEIP\INF\Handler\Handler $listener listener to connect
     *
     * @return
     */
    public function disconnect($name, $listener)
    {
        if (!$this->hasListeners($name)) {
            return false;
        }
        $res = false;
        foreach ($this->listeners[$name] as $i => $callable) {
            if ($listener === $callable) {
                unset($this->listeners[$name][$i]);
                $res = true;
            }
        }

        return $res;
    }

    /**
     * Disconnects a listener from a given event-name.
     *
     * @param string $name name of the event
     *
     * @return
     */
    public function disconnectAll($name)
    {
        if (!isset($this->listeners[$name])) {
            return false;
        }
        $this->listeners[$name] = [];

        return true;
    }

    /**
     * Checks wether any listener is registered for a given event-name.
     *
     * @param string $name name of the event
     *
     * @return bool wether any listener is registered for event-name
     */
    public function hasListeners($name)
    {
        if (!isset($this->listeners[$name])) {
            return false;
        }

        return (bool) count($this->listeners[$name]);
    }

    /**
     * notifies all listeners on a event on a subject.
     *
     * @param string $name    name of the event
     * @param mixed  $subject the subject
     *
     * @return bool success
     */
    public function notify($name, $subject)
    {
        if ($this->hasListeners($name)) {
            self::doNotify($this->getListeners($name), $subject);

            return true;
        }

        return false;
    }

    /**
     * notifies all listeners on a event on a subject until one returns a boolean true value.
     *
     * @param string $name    name of the event
     * @param mixed  $subject the subject
     *
     * @return \PEIP\INF\Handler\Handler listener which returned a boolean true value
     */
    public function notifyUntil($name, $subject)
    {
        if ($this->hasListeners($name)) {
            return self::doNotifyUntil($this->getListeners($name), $subject);
        }
    }

    /**
     * Returns all listeners registered for a given event-name.
     *
     * @param $name
     *
     * @return array array of \PEIP\INF\Handler\Handler instances
     */
    public function getListeners($name)
    {
        if (!isset($this->listeners[$name])) {
            return [];
        }

        return $this->listeners[$name];
    }
}
