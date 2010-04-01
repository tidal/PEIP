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
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage dispatcher 
 */


abstract class PEIP_ABS_Dispatcher {

    
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
