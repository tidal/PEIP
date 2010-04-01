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
   * Connects a listener to a given event name.
   *
   * @param string  $name      An event name
   * @param mixed   $listener  A PHP callable
   */
  
    /**
     * @access public
     * @param $name 
     * @param $listener 
     * @return 
     */
    public function connect($name, PEIP_INF_Handler $listener)
  {
    if (!isset($this->listeners[$name]))
    {
      $this->listeners[$name] = array();
    }

    $this->listeners[$name][] = $listener;
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
     * @param $name 
     * @param $listener 
     * @return 
     */
    public function disconnect($name, PEIP_INF_Handler $listener)
  {
    if (!isset($this->listeners[$name]))
    {
      return false;
    }

    foreach ($this->listeners[$name] as $i => $callable)
    {
      if ($listener === $callable)
      {
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
     * @param $name 
     * @return 
     */
    public function hasListeners($name)
  {
    if (!isset($this->listeners[$name]))
    {
      $this->listeners[$name] = array();
    }
    return (boolean) count($this->listeners[$name]);
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
     * @param $name 
     * @param $subject 
     * @return 
     */
    public function notify($name, $subject){
        if($this->hasListeners($name)){
            return self::doNotify($this->getListeners($name), $subject);    
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
     * @param $name 
     * @param $subject 
     * @return 
     */
    
    /**
     * @access public
     * @param $name 
     * @param $subject 
     * @return 
     */
    public function notifyUntil($name, $subject){
        if($this->hasListeners($name)){
            return self::doNotifyUntil($this->getListeners($name), $subject);   
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
     * @param $name 
     * @return 
     */
    public function getListeners($name)
  {
    if (!isset($this->listeners[$name])){
      return array();
    }
    return $this->listeners[$name];
  }


}

