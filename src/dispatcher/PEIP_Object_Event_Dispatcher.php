<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Object_Event_Dispatcher 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage dispatcher 
 * @extends PEIP_Object_Map_Dispatcher
 * @implements PEIP_INF_Object_Map_Dispatcher
 */



class PEIP_Object_Event_Dispatcher 
    extends PEIP_Object_Map_Dispatcher {
    
    
    
    /**
     * @access public
     * @param $name 
     * @param $object 
     * @param $eventClass 
     * @return 
     */
    public function notify($name, $object, $eventClass = false){
        if($object instanceof PEIP_INF_Event){
            if(is_object($object->getContent())){
                if($this->hasListeners($name, $object->getContent())){
                    return self::doNotify($this->getListeners($name, $object->getContent()), $object);  
                }                   
            }else{
                throw new InvalidArgumentException('instance of PEIP_INF_Event must contain subject');
            }   
        }else{
            throw new InvalidArgumentException('object must be instance of PEIP_INF_Event');
        }  
    }   
    
    
    /**
     * @access public
     * @param $name 
     * @param $object 
     * @param $headers 
     * @param $eventClass 
     * @return 
     */
    public function buildAndNotify($name, $object, array $headers = array(), $eventClass = false){      
        if($this->hasListeners($name, $object)){
            $event = PEIP_Event_Builder::getInstance($eventClass)->build($object, $name, $headers);
            return $this->notify($name, $event);            
        }
    }   
    
    
    
    
    
    
    
    
}