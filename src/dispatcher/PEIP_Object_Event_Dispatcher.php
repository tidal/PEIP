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
 * Event dispatcher for an abritrary amount of different objects and events.
 * Contrary to it´s parent class (PEIP_Object_Map_Dispatcher) this class can
 * create event-objects (PEIP_INF_Event) with the notification subject as content/subject
 * and notify it´s listners on the event-objects. Also this class only accepts instaces of 
 * PEIP_INF_Event as it´s notification subjects.
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
     * Notifies all listeners of a given event-object.
     * 
     * @access public
     * @param string $name name of the event 
     * @param PEIP_INF_Event $object an event object
     * @return boolean
     */
    public function notify($name, $object){
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
     * Creates an event-object with given object as content/subject and notifies
     * all registers listeners of the event.
     * 
     * @access public
     * @param string $name name of the event 
     * @param object $object the subject of the event  
     * @param array $headers headers of the event-object as key/value pairs 
     * @param string $eventClass event-class to create instances from 
     * @return
     * @see PEIP_Event_Builder 
     */
    public function buildAndNotify($name, $object, array $headers = array(), $eventClass = false){      
        if($this->hasListeners($name, $object)){
            $event = PEIP_Event_Builder::getInstance($eventClass)->build($object, $name, $headers);
            return $this->notify($name, $event);            
        }
    }      
    
}