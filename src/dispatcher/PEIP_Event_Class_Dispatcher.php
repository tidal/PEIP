<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PEIP_Event_Class_Dispatcher
 *
 * @author timo
 */
class PEIP_Event_Class_Dispatcher
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
                return self::doNotify(
                    $this->getListeners(
                        $name,
                        $object
                     ),
                     $object->getContent()
                 );
            }else{
                throw new InvalidArgumentException('instance of PEIP_INF_Event must contain subject');
            }
        }else{
            throw new InvalidArgumentException('object must be instance of PEIP_INF_Event');
        }
    }       //put your code here

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
    public function buildAndNotify($name, $object, array $headers = array(), $eventClass = false, $type = false){
        if(!$this->hasListeners($name, ($object))){
            return false;
        }

        return $this->notify(
                $name,
                PEIP_Event_Builder::getInstance($eventClass)->build(
                    $object,
                    $name,
                    $headers,
                    (string)$type
                )
        );
    }

    /**
     * Checks wether an object has a listener for an event
     *
     * @access public
     * @param string $name the event-name
     * @param object $object object to check for listeners
     * @return boolean
     */
    public function hasListeners($name, $object){
        return parent::hasListeners(
            $name,
            PEIP_Reflection_Pool::getInstance($object)
        );
    }
}

