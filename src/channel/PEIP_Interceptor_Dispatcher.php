<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Interceptor_Dispatcher 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 * @extends PEIP_ABS_Map_Dispatcher
 * @implements PEIP_INF_Connectable
 */


class PEIP_Interceptor_Dispatcher 
    extends PEIP_ABS_Map_Dispatcher {


      /**
   * Notifies all listeners of a given event.
   *
   * @param PEIP_Event_Inf $event A PEIP_Event_Inf instance
   *
   * @return PEIP_Event_Inf The PEIP_Event_Inf instance
   */
  
    /**
     * @access public
     * @param $eventName 
     * @param $parameters 
     * @return 
     */
    public function notify($eventName, $parameters){
        foreach($this->getListeners($eventName) as $interceptorHandler){ 
            call_user_func_array(array($interceptorHandler, 'handle'), $parameters);
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
     * @param $eventName 
     * @param $parameters 
     * @return 
     */
    
    /**
     * @access public
     * @param $eventName 
     * @param $parameters 
     * @return 
     */
    public function notifyUntil($eventName, $parameters){
        foreach($this->getListeners($eventName) as $interceptor){ 
            $res = call_user_func_array(array($interceptor, 'handle'), $parameters);
            if($res){
                return $res; 
            }
        }    
    }
  
    
    

}