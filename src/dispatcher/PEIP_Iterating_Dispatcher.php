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
     * @access public
     * @param $listenerIterator 
     * @return 
     */
    public function __construct(ArrayIterator $listenerIterator = NULL){
        $this->listeners = $iterator ? $iterator : new ArrayIterator;
    }
    
 /**
   * Connects a listener to a given event name.
   *
   * @param string  $name      An event name
   * @param mixed   $listener  A PHP callable
   */
  
    /**
     * @access public
     * @param $listener 
     * @return 
     */
    public function connect(PEIP_INF_Handler $listener){
    $this->listeners[] = $listener;
  }

  /**
   * Disconnects a listener for a given event name.
   *
   * @param string   $name      An event name
   * @param mixed    $listener  A PHP callable
   *
   * @return mixed false if listener does not exist, null otherwise
   */
  
    /**
     * @access public
     * @param $listener 
     * @return 
     */
    public function disconnect(PEIP_INF_Handler $listener){
    foreach ($this->listeners as $i => $callable){
      if ($listener === $callable){
        unset($this->listeners[$name][$i]);
      }
    }
  }
    

  /**
   * Returns true if the given event name has some listeners.
   *
   * @param  string   $name    The event name
   *
   * @return Boolean true if some listeners are connected, false otherwise
   */
  
    /**
     * @access public
     * @return 
     */
    public function hasListeners()
  {
    return (boolean) $this->listeners->count();
  }

  /**
   * Notifies all listeners of a given event.
   *
   * @param PEIP_Event_Inf $event A PEIP_Event_Inf instance
   *
   * @return PEIP_Event_Inf The PEIP_Event_Inf instance
   */
    
    /**
     * @access public
     * @param $subject 
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
   * Returns all listeners associated with a given event name.
   *
   * @param  string   $name    The event name
   *
   * @return array  An array of listeners
   */
  
    /**
     * @access public
     * @return 
     */
    public function getListeners(){
    return $this->listeners;
  }
    
}
