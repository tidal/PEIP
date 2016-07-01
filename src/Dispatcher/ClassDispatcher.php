<?php

namespace PEIP\Dispatcher;

use PEIP\Util\Test;
use PEIP\Util\Reflection;

class ClassDispatcher
    extends \PEIP\ABS\Dispatcher\MapDispatcher {



    /**
     * Connects a listener to a given event-name
     *
     * @access public
     * @param string $name name of the class
     * @param Callable|PEIP\INF\Handler\Handler $listener listener to connect
     * @return
     */
    public function connect($name, $listener){
        $name = is_object($name) ? get_class($name) : (string)$name;
        if(Test::assertClassOrInterfaceExists($name)){
            parent::connect($name, $listener);
        }else{
            throw new \InvalidArgumentException($name." is not an Class nor Interface");
        }
    }

    /**
     * notifies all listeners on a event on a subject
     *
     * @access public
     * @param string $name name of the class
     * @param mixed $subject the subject
     * @return
     */
    public function notify($name, $subject){
        $res = false;
        foreach(Reflection::getImplementedClassesAndInterfaces($name) as $cls){
            if(parent::hasListeners($cls)){
                self::doNotify($this->getListeners($cls), $subject);
                $res = true;
            }
        }
        
        return $res;
    }


    /**
     * notifies all listeners on a event on a subject until one returns a boolean true value
     *
     * @access public
     * @param string $name name of the event
     * @param mixed $subject the subject
     * @return \PEIP\INF\Handler\Handler listener which returned a boolean true value
     */
    public function notifyUntil($name, $subject){
        $res = NULL;
        foreach(Reflection::getImplementedClassesAndInterfaces($name) as $cls){
            if(!$res && parent::hasListeners($cls)){
                $res = self::doNotifyUntil($this->getListeners($cls), $subject);
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
        foreach(Reflection::getImplementedClassesAndInterfaces($name) as $cls){
            if(parent::hasListeners($cls)){
                return true;
            }
        }

        return false;
    }

}

