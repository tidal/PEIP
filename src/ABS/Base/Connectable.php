<?php
/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP\ABS\Base\Connectable
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP
 * @subpackage base 
 */
use PEIP\Dispatcher\Dispatcher;
use PEIP\Dispatcher\ObjectEventDispatcher;
use PEIP\Event\Event;
use PEIP\Util\Test;

namespace PEIP\ABS\Base;

abstract class Connectable  implements \PEIP\INF\Event\Connectable{

    const
        DEFAULT_CLASS_MESSAGE_DISPATCHER = 'Dispatcher',
        DEFAULT_CLASS_EVENT_DISPATCHER = 'ObjectEventDispatcher',
        DEFAULT_EVENT_CLASS = 'Event',
        EVENT_CONNECT = 'connect',
        EVENT_DISCONNECT = 'disconnect',
        EVENT_SET_EVENT_DISPATCHER = 'setEventDispatcher',
        HEADER_DISPATCHER = 'DISPATCHER',
        HEADER_LISTENER = 'LISTENER',
        HEADER_EVENT = 'EVENT';
    
    protected static
        $sharedEventDispatcher;

    protected
        $eventDispatcher;
    
    /**
     * @access public
     * @param $name
     * @param Callable|PEIP\INF\Handler\Handler $listener
     * @return
     */
    public function connect($name, $listener){
        Test::ensureHandler($listener);
        $this->getEventDispatcher()->connect($name, $this, $listener);
        $this->doFireEvent(
            self::EVENT_CONNECT,
            array(
                self::HEADER_EVENT=>$name,
                self::HEADER_LISTENER=>$listener
            )
        );
    }


    /**
     * @access public
     * @param $name
     * @param Callable|PEIP\INF\Handler\Handler $listener
     * @return
     */
    public function disconnect($name, $listener){
        Test::ensureHandler($listener);
        $this->getEventDispatcher()->disconnect($name, $this, $listener);
        $this->doFireEvent(
            self::EVENT_DISCONNECT,
            array(
                self::HEADER_EVENT=>$name,
                self::HEADER_LISTENER=>$listener
            ),
            false,
            ''

        );
    }


    /**
     * @access public
     * @param $name
     * @return
     */
    public function hasListeners($name){
        return $this->getEventDispatcher()->hasListeners($name, $this);
    }


    /**
     * @access public
     * @param $name
     * @return
     */
    public function getListeners($name){
        return $this->getEventDispatcher()->getListeners($name, $this);
    }

    /**
     * @access public
     * @param $eventName
     * @param $callable
     * @return
     */
    public function disconnectAll($name){
        $this->getEventDispatcher()->disconnectAll($name, $this);
    }

    /**
     * @access public
     * @param $dispatcher
     * @param $transferListners
     * @return
     */
    public function setEventDispatcher(ObjectEventDispatcher $dispatcher, $transferListners = true){
        if($transferListners){
            foreach($this->getEventDispatcher()->getEventNames($this) as $name){
                if($this->getEventDispatcher()->hasListeners($name, $this)){
                    foreach($this->getEventDispatcher()->getListeners($name, $this) as $listener){
                        $dispatcher->connect($name, $this, $listener);
                    }
                }
            }
        }
        $this->eventDispatcher = $dispatcher;
        $this->doFireEvent(self::EVENT_SET_EVENT_DISPATCHER, array(self::HEADER_DISPATCHER=>$dispatcher));
    }


    /**
     * @access public
     * @return
     */
    public function getEventDispatcher(){
        return $this->eventDispatcher ? $this->eventDispatcher : $this->eventDispatcher = self::getSharedEventDispatcher();
    }

    protected static function getSharedEventDispatcher(){
        $defaultDispatcher = self::DEFAULT_CLASS_EVENT_DISPATCHER;
        return self::$sharedEventDispatcher ? self::$sharedEventDispatcher : self::$sharedEventDispatcher = new $defaultDispatcher;
    }


    /**
     * @access protected
     * @param $name
     * @param $headers
     * @param $eventClass
     * @return
     */
    protected function doFireEvent($name, array $headers = array(), $eventClass = '', $type = false){
        $eventClass = trim($eventClass) == '' ? static::DEFAULT_EVENT_CLASS : $eventClass;
        return $this->getEventDispatcher()->buildAndNotify($name, $this, $headers, $eventClass, $type);
    }

    protected static function getDefaultEventClass(){
        return self::DEFAULT_EVENT_CLASS;
    }
}

