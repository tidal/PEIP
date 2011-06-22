<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Iterating_Dispatcher 
 * Dispatcher implementation which notifies only one listener at a time 
 * by iterating over registered listeners.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage dispatcher 
 * @implements PEIP_INF_Dispatcher
 */

class PEIP_Iterating_Dispatcher
    extends PEIP_ABS_Dispatcher
    implements 
        PEIP_INF_Dispatcher,
        PEIP_INF_Plugable {

    protected 
        $listeners;
    
    /**
     * constructor
     * 
     * @access public
     * @param mixed array|ArrayAccess array with values to iterate over
     * @return 
     */
    public function __construct($array = array()){
        $this->init($array);
    }

    protected function init($array = array()){
        $array = PEIP_Test::assertArrayAccess($array)
            ? $array
            : array();
        $this->listeners = new ArrayIterator($array);
    }

    /**
     * Registers a listener.
     * 
     * @access public
     * @param mixed $listener the listener to register
     * @return 
     */
    public function connect($listener){
    	$this->listeners[] = $listener;
  	}

    /**
     * Unregisters a listener.
     * 
     * @access public
     * @param mixed $listener the listener to unregister
     * @return 
     */
    public function disconnect($listener){
        foreach ($this->listeners as $i => $callable){
            if ($listener === $callable){
                unset($this->listeners[$i]);
            }
        }
    }


    /**
     * Unregisters all listeners.
     *
     * @access public
     * @return
     */
    public function disconnectAll(){
        $this->init();
    }

    /**
     * Check wether any listener is registered
     * 
     * @access public
     * @return boolean wether any listener is registered
     */
    public function hasListeners(){
    	return (boolean) $this->listeners->count();
  	}

    /**
     * Notifies one listener about a subject.
     * Iterates to the next registered listener any time method
     * is called - Rewinds if end is reached.  
     * 
     * @access public
     * @param mixed $subject the subject to notify about 
     * @return 
     */
    public function notify($subject){
        $res = NULL;
        if($this->hasListeners()){
            if(!$this->listeners->valid()){
                $this->listeners->rewind();
            }
            $res = self::doNotifyOne($this->listeners->current(), $subject);
            $this->listeners->next();
        }
        return $res;
    }
  
    /**
     * Returns all registered listeners of the dispatcher
     * 
     * @access public
     * @return array registered listeners 
     */
    public function getListeners(){
    	return $this->listeners->getArrayCopy();
    }
    
}
