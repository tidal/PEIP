<?php

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP\ABS\Dispatcher\Dispatcher 
 * Abstract dispatcher base class.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage dispatcher 
 */


namespace PEIP\ABS\Dispatcher;

abstract class Dispatcher {
    
    /**
     * notifies given listeners of given subject
     * 
     * @access protected
     * @static 
     * @param array array of \PEIP\INF\Handler\Handler instaces
     * @param mixed $subject subject to notify the listeners of 
     * @return void
     */ 
    protected static function doNotify(array $listeners, $subject){
        foreach($listeners as $listener){
            self::doNotifyOne($listener, $subject);
        }   
    }  

    protected static function doNotifyOne($listener, $subject){
        if(is_callable($listener)){
            $res = call_user_func($listener, $subject);
        }else{
            $res = $listener->handle($subject);
        }
        return $res;
    }


    /**
     * notifies given listeners on a subject until one returns a boolean true value
     * 
     * @access protected
     * @static 
     * @param array array of \PEIP\INF\Handler\Handler instaces
     * @param mixed $subject subject to notify the listeners of 
     * @return \PEIP\INF\Handler\Handler listener that returned a boolean true value
     */     
    protected static function doNotifyUntil(array $listeners, $subject){
        foreach ($listeners as $listener){
          if (self::doNotifyOne($listener, $subject)){
            return $listener;
          }
        }
        return NULL;
    } 

}
