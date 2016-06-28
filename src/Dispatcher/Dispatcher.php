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

/**
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

class Dispatcher 
    extends \PEIP\ABS\Dispatcher\Dispatcher 
    implements 
        \PEIP\INF\Dispatcher\Dispatcher,
        \PEIP\INF\Base\Plugable {

    protected $listeners = array();
     
    /**
     * Connects a listener.
     * 
     * @access public
     * @param Callable|PEIP\INF\Handler\Handler  $listener
     * @return void
     */
    public function connect($listener){
        Test::ensureHandler($listener);
        $this->listeners[] = $listener;
    }
 
    /**
     * Disconnects a listener.
     * 
     * @access public
     * @param Callable|PEIP\INF\Handler\Handler $listener
     * @return void
     */
    public function disconnect($listener){
        Test::ensureHandler($listener);
        foreach ($this->listeners as $i => $callable){
            if ($listener === $callable){
                unset($this->listeners[$i]);
            }
        }
    }
   
    /**
     * Disconnects all listeners.
     * 
     * @access public
     * @param Callable|PEIP\INF\Handler\Handler $listener
     * @return void
     */
    public function disconnectAll(){
        $this->listeners = array();
    }

    /**
     * returns wether any listeners are registered
     * 
     * @access public
     * @return boolean wether any listeners are registered
     */
    public function hasListeners(){
        return (boolean) count($this->listeners);
    }
    
    /**
     * notifies all listeners on a subject
     * 
     * @access public
     * @param mixed $subject the subject
     * @return void
     */
    public function notify($subject){
        $res = NULL;
        if($this->hasListeners()){
            $res = self::doNotify($this->getListeners(), $subject); 
        }   
        return $res;      
    }
    
    /**
     * notifies all listeners on a subject until one returns a boolean true value
     * 
     * @access public
     * @param mixed $subject the subject 
     * @return \PEIP\INF\Handler\Handler the listener which returned a boolean true value
     */
    public function notifyUntil($subject){
        if($this->hasListeners()){
            $res = self::doNotifyUntil($this->getListeners(), $subject);    
        }
        return $res;
    }
  
    /**
     * returns all listeners
     * 
     * @access public
     * @return array the listeners
     */
    public function getListeners(){
        return $this->listeners;
    }

}
