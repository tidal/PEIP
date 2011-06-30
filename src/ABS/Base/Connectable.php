<?php

namespace PEIP\ABS\Base;
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

use \PEIP\Constant\Header;
use \PEIP\Constant\Event;
use \PEIP\Constant\Fallback;

abstract class Connectable  implements \PEIP\INF\Event\Connectable{
  
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
        \PEIP\Util\Test::ensureHandler($listener);
        $this->getEventDispatcher()->connect($name, $this, $listener);
        $this->doFireEvent(
            Event::CONNECT,
            array(
                HEADER::EVENT=>$name,
                HEADER::LISTENER=>$listener
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
        \PEIP\Util\Test::ensureHandler($listener);
        $this->getEventDispatcher()->disconnect($name, $this, $listener);
        $this->doFireEvent(
            Event::DISCONNECT,
            array(
                HEADER::EVENT=>$name,
                HEADER::LISTENER=>$listener
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
    public function setEventDispatcher(\PEIP\Dispatcher\ObjectEventDispatcher $dispatcher, $transferListners = true){
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
        $this->doFireEvent(Event::SET_EVENT_DISPATCHER, array(HEADER::DISPATCHER=>$dispatcher));
    }


    /**
     * @access public
     * @return
     */
    public function getEventDispatcher(){
        return $this->eventDispatcher ? $this->eventDispatcher : $this->eventDispatcher = self::getSharedEventDispatcher();
    }

    protected static function getSharedEventDispatcher(){
        $defaultDispatcher = Fallback::CLASS_EVENT_DISPATCHER;
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
        $eventClass = trim($eventClass) == '' ? Fallback::EVENT_CLASS : $eventClass;
        $headers['TIME'] = \microtime(true);
        return $this->getEventDispatcher()->buildAndNotify($name, $this, $headers, $eventClass, $type);
    }


}

