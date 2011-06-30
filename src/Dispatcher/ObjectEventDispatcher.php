<?php

namespace PEIP\Dispatcher;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * ObjectEventDispatcher 
 * Event dispatcher for an abritrary amount of different objects and events.
 * Contrary to it�s parent class \PEIP\Dispatcher\ObjectMapDispatcher) this class can
 * create event-objects (\PEIP\INF\Event\Event) with the notification subject as content/subject
 * and notify it�s listners on the event-objects. Also this class only accepts instaces of 
 * \PEIP\INF\Event\Event as it�s notification subjects.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage dispatcher 
 * @extends \PEIP\Dispatcher\ObjectMapDispatcher
 * @implements \PEIP\INF\Dispatcher\ObjectMapDispatcher
 */

use PEIP\Event\EventBuilder;

class ObjectEventDispatcher 
    extends \PEIP\Dispatcher\ObjectMapDispatcher {

    /**
     * Notifies all listeners of a given event-object.
     * 
     * @access public
     * @param string $name name of the event 
     * @param \PEIP\INF\Event\Event $object an event object
     * @return boolean
     */
    public function notify($name, $object){
        if($object instanceof \PEIP\INF\Event\Event){
            if(is_object($object->getContent())){
                if($this->hasListeners($name, $object->getContent())){
                    return self::doNotify($this->getListeners($name, $object->getContent()), $object);  
                }                   
            }else{
                throw new \InvalidArgumentException('instance of \PEIP\INF\Event\Event must contain subject');
            }   
        }else{
            throw new \InvalidArgumentException('object must be instance of \PEIP\INF\Event\Event');
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
     * @see EventBuilder 
     */
    public function buildAndNotify($name, $object, array $headers = array(), $eventClass = false, $type = false){
        if(!$this->hasListeners($name, $object)){
            return false;
        }
        $event = EventBuilder::getInstance($eventClass)->build(
            $object,
            $name,
            $headers
        );
        $this->notify(
            $name,
            $event
        );
        return $event;
    }      
    
}