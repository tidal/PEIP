<?php

namespace PEIP\Dispatcher;

namespace PEIP\Dispatcher;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * Dispatcher
 * Basic dispatcher implementation
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP
 * @subpackage dispatcher
 * @extends \PEIP\ABS\Dispatcher\Dispatcher
 * @implements \PEIP\INF\Dispatcher\Dispatcher
 */

use PEIP\Util\Test;

class Dispatcher extends \PEIP\ABS\Dispatcher\Dispatcher implements
        \PEIP\INF\Dispatcher\Dispatcher,
        \PEIP\INF\Base\Plugable
{
    protected $listeners = [];

    /**
     * Connects a listener.
     *
     * @param callable|PEIP\INF\Handler\Handler $listener
     *
     * @return void
     */
    public function connect($listener)
    {
        Test::ensureHandler($listener);
        $this->listeners[] = $listener;
    }

    /**
     * Disconnects a listener.
     *
     * @param callable|PEIP\INF\Handler\Handler $listener
     *
     * @return void
     */
    public function disconnect($listener)
    {
        Test::ensureHandler($listener);
        foreach ($this->listeners as $i => $callable) {
            if ($listener === $callable) {
                unset($this->listeners[$i]);
            }
        }
    }

    /**
     * Disconnects all listeners.
     *
     * @param callable|PEIP\INF\Handler\Handler $listener
     *
     * @return void
     */
    public function disconnectAll()
    {
        $this->listeners = [];
    }

    /**
     * returns wether any listeners are registered.
     *
     * @return bool wether any listeners are registered
     */
    public function hasListeners()
    {
        return (bool) count($this->listeners);
    }

    /**
     * notifies all listeners on a subject.
     *
     * @param mixed $subject the subject
     *
     * @return void
     */
    public function notify($subject)
    {
        $res = null;
        if ($this->hasListeners()) {
            $res = self::doNotify($this->getListeners(), $subject);
        }

        return $res;
    }

    /**
     * notifies all listeners on a subject until one returns a boolean true value.
     *
     * @param mixed $subject the subject
     *
     * @return \PEIP\INF\Handler\Handler the listener which returned a boolean true value
     */
    public function notifyUntil($subject)
    {
        if ($this->hasListeners()) {
            $res = self::doNotifyUntil($this->getListeners(), $subject);
        }

        return $res;
    }

    /**
     * returns all listeners.
     *
     * @return array the listeners
     */
    public function getListeners()
    {
        return $this->listeners;
    }
}
