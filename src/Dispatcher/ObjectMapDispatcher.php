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
 * ObjectMapDispatcher
 * Event dispatcher for an abritrary amount of different objects and events.
 * Framework internally this class (and derived classes) are used to reduce the overall
 * amount of dispatcher instances.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP
 * @subpackage dispatcher
 * @implements \PEIP\INF\Dispatcher\ObjectMapDispatcher
 */

use PEIP\Base\ObjectStorage;
use PEIP\Util\Test;

class ObjectMapDispatcher implements \PEIP\INF\Dispatcher\ObjectMapDispatcher
{
    protected $listeners = null,
        $classDispatcher = null;

    /**
     * connects a Handler to an event on an object.
     *
     * @param string                            $name     the event-name
     * @param object                            $object   arbitrary object to connect to
     * @param callable|PEIP\INF\Handler\Handler $listener event-handler
     *
     * @return bool
     */
    public function connect($name, $object, $listener)
    {
        Test::ensureHandler($listener);
        $listners = $this->doGetListeners();
        if (!$this->listeners->contains($object)) {
            $this->listeners->attach($object, new \ArrayObject());
        }
        if (!array_key_exists($name, $listners[$object])) {
            $this->listeners[$object][$name] = [];
        }
        $hash = $this->getListenerHash($listener);
        $this->listeners[$object][$name][$hash] = $listener;

        return true;
    }

    /**
     * Disconnects a Handler from an event on an object.
     *
     * @param string                    $name     the event-name
     * @param object                    $object   arbitrary object to disconnect from
     * @param \PEIP\INF\Handler\Handler $listener event-handler
     *
     * @return bool
     */
    public function disconnect($name, $object, $listener)
    {
        $listners = $this->doGetListeners();
        if (!$listners->contains($object) || !isset($listners[$object][$name])) {
            return false;
        }
        $eventListeners = $listners[$object][$name];
        $hash = $this->getListenerHash($listener);
        if (isset($eventListeners[$hash])) {
            unset($eventListeners[$hash]);

            $listners[$object][$name] = $eventListeners;

            return true;
        }

        return false;
    }

    public function disconnectAll($name, $object)
    {
        if (is_object($object)) {
            $listners = $this->doGetListeners();
            if ($listners && $this->hadListeners($name, $object)) {
                $listners[$object][$name] = [];
            }
        }
    }

    /**
     * Checks wether an object has a listener for an event.
     *
     * @param string $name   the event-name
     * @param object $object object to check for listeners
     *
     * @return bool
     */
    public function hasListeners($name, $object)
    {
        $listners = $this->doGetListeners();
        if (!$this->hadListeners($name, $object)) {
            $res = false;
        } else {
            $listners = $this->doGetListeners();
            $res = (bool) count($listners[$object][$name]);
        }

        return $res;
    }

    /**
     * Checks wether an object has or had a listener for an event.
     *
     * @param string $name   the event-name
     * @param object $object object to check for listeners
     *
     * @return bool
     */
    public function hadListeners($name, $object)
    {
        $listners = $this->doGetListeners();

        return ($listners->contains($object) && isset($listners[$object][$name])) ? true : false;
    }

    /**
     * Returns all event-names an object has registered listeners for.
     *
     * @param object $object object to get event-names for
     *
     * @return string[] array of event-names
     */
    public function getEventNames($object)
    {
        $listeners = $this->doGetListeners();
        if (!$listeners->contains($object)) {
            return [];
        }

        return array_keys($listeners[$object]->getArrayCopy());
    }

    /**
     * Notifies all listeners of a given event on an object.
     *
     * @param $name
     * @param $object
     *
     * @return bool
     */
    public function notify($name, $object)
    {
        if ($this->hasListeners($name, $object)) {
            $listners = $this->doGetListeners();
            self::doNotify($listners[$object][$name], $object);
        }

        return true;
    }

    /**
     * Notifies all listeners of a given event on an object
     * until one returns a non null value.
     *
     * @param $name
     * @param $subject
     *
     * @return \PEIP\INF\Handler\Handler
     */
    public function notifyUntil($name, $subject)
    {
        if ($this->hasListeners($name, $subject)) {
            $res = self::doNotifyUntil($this->getListeners($name, $subject), $subject);
        }

        return $res;
    }

    /**
     * Returns all listeners of a given event on an object.
     *
     * @param string $name   the event-name
     * @param object $object object to check for listeners
     *
     * @return array array of listeners
     */
    public function getListeners($name, $object)
    {
        if (!$this->hadListeners($name, $object)) {
            return [];
        }
        $listeners = $this->listeners[$object]->getArrayCopy();

        return array_values($listeners[$name]);
    }

    /**
     * Returns ObjectStorage object to store objects to lositen to in.
     * creates ObjectStorage if not exists.
     *
     * @return ObjectStorage
     */
    protected function doGetListeners()
    {
        return isset($this->listeners) ? $this->listeners : $this->listeners = new ObjectStorage();
    }

    /**
     * Notifies all given listeners about an subject.
     *
     * @static
     *
     * @param $name
     * @param $object
     *
     * @return bool|null
     */
    protected static function doNotify(array $listeners, $subject)
    {
        foreach ($listeners as $listener) {
            if ($listener instanceof \PEIP\INF\Handler\Handler) {
                $listener->handle($subject);
            } elseif (is_callable($listener)) {
                call_user_func($listener, $subject);
            }
        }
    }

    /**
     * Notifies all given listeners about an subject untill one returns a boolean true value.
     *
     * @static
     *
     * @param $name
     * @param $object
     *
     * @return \PEIP\INF\Handler\Handler the listener which returned a boolean true value
     */
    protected static function doNotifyUntil(array $listeners, $subject)
    {
        $res = null;
        foreach ($listeners as $listener) {
            if ($listener instanceof \PEIP\INF\Handler\Handler) {
                $res = $listener->handle($subject);
                if ($res) {
                    return $listener;
                }
            }
        }

        return $res;
    }

    protected function getListenerHash($listener)
    {
        if (!is_object($listener)) {
            $o = new \stdClass();
            $o->listener = $listener;
            $listener = $o;
        }

        return spl_object_hash($listener);
    }
}
