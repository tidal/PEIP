<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Dispatcher 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage dispatcher 
 * @extends PEIP_ABS_Dispatcher
 * @implements PEIP_INF_Dispatcher
 */



class PEIP_Dispatcher 
    extends PEIP_ABS_Dispatcher 
    implements PEIP_INF_Dispatcher {

    protected $listeners = array();
    
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
    return (boolean) count($this->listeners);
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
            return self::doNotify($this->getListeners(), $subject); 
        }         
    }

   
  /**
   * Notifies all listeners of a given event until one returns a non null value.
   *
   * @param  PEIP_Event_Inf $event A PEIP_Event_Inf instance
   *
   * @return PEIP_Event_Inf The PEIP_Event_Inf instance
   */
  
    /**
     * @access public
     * @param $subject 
     * @return 
     */
    
    /**
     * @access public
     * @param $subject 
     * @return 
     */
    public function notifyUntil($subject){
        if($this->hasListeners()){
            return self::doNotifyUntil($this->getListeners(), $subject);    
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
