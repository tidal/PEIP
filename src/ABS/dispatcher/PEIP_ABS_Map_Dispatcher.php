<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_ABS_Map_Dispatcher 
 * Abstract base class for namespaced dispatcher.
 * Derived concrete classes can be used (for example) as event dispatchers.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage dispatcher 
 * @extends PEIP_ABS_Dispatcher
 * @implements PEIP_INF_Connectable
 */

abstract class  PEIP_ABS_Map_Dispatcher
    extends 
        PEIP_ABS_Dispatcher 
    implements 
        //PEIP_INF_Map_Dispatcher,
        PEIP_INF_Connectable {

    protected 
        $listeners = array();   
     
    /**
     * Connects a listener to a given event-name
     * 
     * @access public
     * @param string $name name of the event 
     * @param $listener listener to connect
     * @return 
     */
    public function connect($name, PEIP_INF_Handler $listener){
	    if (!isset($this->listeners[$name])){
	      $this->listeners[$name] = array();
	    }
	    $this->listeners[$name][] = $listener;
    }

    /**
     * Disconnects a listener from a given event-name
     * 
     * @access public
     * @param string $name name of the event 
     * @param $listener listener to connect
     * @return 
     */
    public function disconnect($name, PEIP_INF_Handler $listener){
    	if (!isset($this->listeners[$name])){
      		return false;
    	}
	    foreach ($this->listeners[$name] as $i => $callable){
	      if ($listener === $callable){
	        unset($this->listeners[$name][$i]);
	      }
	    }
  	}

    /**
     * Checks wether any listener is registered for a given event-name
     * 
     * @access public
     * @param string $name name of the event 
     * @return boolean wether any listener is registered for event-name
     */
    public function hasListeners($name){
    	if (!isset($this->listeners[$name])){
      		$this->listeners[$name] = array();
    	}
    	return (boolean) count($this->listeners[$name]);
  	}
    
    /**
     * notifies all listeners on a event on a subject
     * 
     * @access public
     * @param string $name name of the event 
     * @param mixed $subject the subject 
     * @return 
     */
    public function notify($name, $subject){
        if($this->hasListeners($name)){
            return self::doNotify($this->getListeners($name), $subject);    
        }         
    }

    /**
     * notifies all listeners on a event on a subject until one returns a boolean true value
     * 
     * @access public
     * @param string $name name of the event 
     * @param mixed $subject the subject 
     * @return PEIP_INF_Handler listener which returned a boolean true value
     */
    public function notifyUntil($name, $subject){
        if($this->hasListeners($name)){
            return self::doNotifyUntil($this->getListeners($name), $subject);   
        }
  	}
  
    /**
     * Returns all listeners registered for a given event-name
     * 
     * @access public
     * @param $name 
     * @return array array of PEIP_INF_Handler instances
     */
    public function getListeners($name){
    	if (!isset($this->listeners[$name])){
      	return array();
    	}
    	return $this->listeners[$name];
  	}

}

