<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_ABS_Dispatcher 
 * Abstract dispatcher base class.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage dispatcher 
 */

abstract class PEIP_ABS_Dispatcher {
	
    /**
     * notifies given listeners of given subject
     * 
     * @access protected
     * @static 
     * @param array array of PEIP_INF_Handler instaces
     * @param mixed $subject subject to notify the listeners of 
     * @return void
     */	
    protected static function doNotify(array $listeners, $subject){
        foreach($listeners as $listener){
            $listener->handle($subject);    
        }   
    }  

    /**
     * notifies given listeners on a subject until one returns a boolean true value
     * 
     * @access protected
     * @static 
     * @param array array of PEIP_INF_Handler instaces
     * @param mixed $subject subject to notify the listeners of 
     * @return PEIP_INF_Handler listener that returned a boolean true value
     */	    
    protected static function doNotifyUntil(array $listeners, $subject){
        foreach ($listeners as $listener){
          if ($listener->handle($subject)){
            return $listener;
          }
        }
    } 

}
