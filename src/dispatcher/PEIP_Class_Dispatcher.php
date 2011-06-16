<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PEIP_Class_Dispatcher
 *
 * @author timo
 */
class PEIP_Class_Dispatcher
	extends PEIP_ABS_Map_Dispatcher {

    /**
     * notifies all listeners on a event on a subject
     *
     * @access public
     * @param string $name name of the event
     * @param mixed $subject the subject
     * @return
     */
    public function notify($name, $subject){
    	$res = false;
        foreach(PEIP_Reflection::getImplementedClassesAndInterfaces($name) as $cls){
            if(parent::hasListeners($cls)){
                $res = self::doNotify($this->getListeners($cls), $subject);
            }
        }
        
        return $res;
    }

    /**
     * notifies all listeners on a event on a subject
     *
     * @access public
     * @param string $name name of the event
     * @param mixed $subject the subject
     * @return
     */
    public function notifyOfInstance($subject){

        return $this->notify(get_class($subject), $subject);
    }
    /**
     * Checks wether any listener is registered for a given event-name
     *
     * @access public
     * @param string $name name of the event
     * @return boolean wether any listener is registered for event-name
     */
    public function hasListeners($name){
    	foreach(PEIP_Reflection::getImplementedClassesAndInterfaces($name) as $cls){
            if(parent::hasListeners($cls)){
                return true;
            }
        }

    	return false;
  	}

}

