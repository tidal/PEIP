<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Object_Map_Dispatcher 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage dispatcher 
 * @implements PEIP_INF_Object_Map_Dispatcher
 */


class PEIP_Object_Map_Dispatcher
    implements PEIP_INF_Object_Map_Dispatcher {

    protected 
        $listeners = NULL;

        

  
    /**
     * @access public
     * @param $name 
     * @param $object 
     * @param $listener 
     * @return 
     */
    public function connect($name, $object, PEIP_INF_Handler $listener)
  {
    $listners = $this->doGetListeners();
    if (!isset($listners[$object])){
      $listners[$object] = new ArrayObject;
    }
    if (!array_key_exists($name, $listners[$object])){ 
      $listners[$object][$name] = array();
    } 
    $this->listeners[$object][$name][] = $listener; 
    
  }


  
    /**
     * @access public
     * @param $name 
     * @param $object 
     * @param $listener 
     * @return 
     */
    public function disconnect($name, $object, PEIP_INF_Handler $listener){
    $listners = $this->doGetListeners();
    if (!isset($listners[$object]) || !isset($listners[$object][$name]))
    {
      return false;
    }

    foreach ($listners[$object][$name] as $i => $callable)
    {
      if ($listener === $callable)
      {
        unset($this->listeners[$object][$name][$i]);
      }
    }
  }

  
    /**
     * @access public
     * @param $name 
     * @param $object 
     * @param $listener 
     * @return 
     */
    
    /**
     * @access public
     * @return 
     */
    public function connectClass(){
  
  
  
  }
  
  
  
  
  
    /**
     * @access public
     * @param $name 
     * @param $object 
     * @return 
     */
    public function hasListeners($name, $object){
    $listners = $this->doGetListeners();
    if (!$this->hadListeners($name, $object)){
        $res = false;
    }else{
        $res = (boolean) count($this->getListeners($name, $object));
    }
    return $res;
  }

  
    /**
     * @access public
     * @param $name 
     * @param $object 
     * @return 
     */
    public function hadListeners($name, $object){
    $listners = $this->doGetListeners();
    return (isset($listners[$object]) && isset($listners[$object][$name])) ? true : false;  
  }

  
    /**
     * @access public
     * @param $object 
     * @return 
     */
    public function getEventNames($object){
    if (!$this->hadListeners($name, $object)){
      return array();
    }
    return array_keys($this->listeners[$object]);
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
     * @param $object 
     * @return 
     */
    public function notify($name, $object){
        if($this->hasListeners($name, $object)){
            return self::doNotify($this->getListeners($name, $object), $subject);   
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
     * @param $object 
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
     * @param $object 
     * @return 
     */
    public function getListeners($name, $object)
  {
    if (!$this->hadListeners($name, $object)){
      return array();
    }
    return $this->listeners[$object][$name];
  }

    
    /**
     * @access protected
     * @return 
     */
    protected function doGetListeners(){
        return isset($this->listeners) ? $this->listeners : $this->listeners = new SplObjectStorage();
    }

    protected static function doNotify(array $listeners, $subject){
        foreach($listeners as $listener){
            $listener->handle($subject);    
        }   
    }  

    protected static function doNotifyUntill(array $listeners, $subject){
        foreach ($listeners as $listener){
          if ($listener->handle($subject)){
            return $listener;
          }
        }
    } 

}

