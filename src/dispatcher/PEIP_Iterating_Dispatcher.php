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
    implements PEIP_INF_Dispatcher {

    protected $listeners;
    
    /**
     * constructor
     * 
     * @access public
     * @param ArrayIterator $listenerIterator an instance of ArrayIterator to iterate over listeners
     * @return 
     */
    public function __construct(ArrayIterator $listenerIterator = NULL){
        $this->listeners = $listenerIterator ? $listenerIterator : new ArrayIterator;
    }
  
    /**
     * Registers a listener.
     * 
     * @access public
     * @param PEIP_INF_Handler $listener the listener to register
     * @return 
     */
    public function connect(PEIP_INF_Handler $listener){
    	$this->listeners[] = $listener;
  	}

    /**
     * Unregisters a listener.
     * 
     * @access public
     * @param PEIP_INF_Handler $listener the listener to unregister 
     * @return 
     */
    public function disconnect(PEIP_INF_Handler $listener){
        foreach ($this->listeners as $i => $callable){
            if ($listener === $callable){
                unset($this->listeners[$i]);
            }
        }
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
        if($this->hasListeners()){
            if(!$this->listeners->valid()){
                $this->listeners->rewind(); 
            }
            $this->listeners->current()->handle($subject);
            $this->listeners->next();           
        }         
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
