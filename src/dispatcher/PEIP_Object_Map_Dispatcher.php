<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Object_Map_Dispatcher 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage dispatcher 
 * @implements PEIP_INF_Object_Map_Dispatcher
 */


class PEIP_Object_Map_Dispatcher
    implements PEIP_INF_Object_Map_Dispatcher {

    protected 
        $listeners = NULL;

         
    /**
     * connects a Handler to an event on an object
     * 
     * @access public
     * @param string $name the event-name 
     * @param object $object arbitrary object to connect to
     * @param PEIP_INF_Handler $listener event-handler
     * @return boolean
     */
    public function connect($name, $object, PEIP_INF_Handler $listener){
	    $listners = $this->doGetListeners();
	    if (!isset($listners[$object])){
	      	$listners[$object] = new ArrayObject;
	    }
	    if (!array_key_exists($name, $listners[$object])){ 
	      	$listners[$object][$name] = array();
	    } 
	    $this->listeners[$object][$name][spl_object_hash($listener)] = $listener; 
	    return true; 
  	}

    /**
     * disconnects a Handler from an event on an object
     * 
     * @access public
     * @param string $name the event-name 
     * @param object $object arbitrary object to disconnect from
     * @param PEIP_INF_Handler $listener event-handler
     * @return boolean
     */
    public function disconnect($name, $object, PEIP_INF_Handler $listener){
	    $listners = $this->doGetListeners();
	    if (!isset($listners[$object]) || !isset($listners[$object][$name])){
	      	return false;
	    }
	    $eventListeners = $listners[$object][$name];
	    $hash = spl_object_hash($listener);
	    if(isset($eventListeners[$hash])){
	    	unset($eventListeners[$hash]);
	    	$listners[$object][$name] = $eventListeners;
	    	return true;
	    }
	    return false;
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
    	$listners = $this->doGetListeners();
    	if (!$this->hadListeners($name, $object)){
        	$res = false;
    	}else{
        	$res = (boolean) count($this->getListeners($name, $object));
    	}
    	return $res;
  	}

    /**
     * Checks wether an object has or had a listener for an event
     * 
     * @access public
     * @param string $name the event-name 
     * @param object $object object to check for listeners
     * @return boolean
     */
    public function hadListeners($name, $object){
    	$listners = $this->doGetListeners();
    	return (isset($listners[$object]) && isset($listners[$object][$name])) ? true : false;  
  	}

    /**
     * @access public
     * @param object $object object to get event-names for
     * @return string[] array of event-names
     */
    public function getEventNames($object){
    	$listeners = $this->doGetListeners();
    	if (!isset($listeners[$object])){
      		return array();
    	}
    	return array_keys($listeners[$object]->getArrayCopy());
	}
    
    /**
     * Notifies all listeners of a given event on an object.
     * 
     * @access public
     * @param $name 
     * @param $object 
     * @return boolean
     */
    public function notify($name, $object){
        if($this->hasListeners($name, $object)){
            self::doNotify($this->getListeners($name, $object), $object);   
        }
        return true;         
    }

    /**
     * Notifies all listeners of a given event on an object 
     * until one returns a non null value.
     * 
     * @access public
     * @param $name 
     * @param $subject 
     * @return mixed
     */
    public function notifyUntil($name, $subject){
    	if($this->hasListeners($name, $subject)){  		
            $res = self::doNotifyUntil($this->getListeners($name, $subject), $subject);   
        }
        return $res;
  	}

    /**
     * returns all listeners of a given event on an object
     * 
     * @access public
     * @param string $name the event-name 
     * @param object $object object to check for listeners
     * @return array array of listeners
     */
    public function getListeners($name, $object){
	    if (!$this->hadListeners($name, $object)){
	      	return array();
	    }
    	return array_values($this->listeners[$object][$name]);
  	}
    
    /**
     * returns SplObjectStorage object to store objects to lositen to in.
     * creates SplObjectStorage if not exists.
     * 
     * @access protected
     * @return SplObjectStorage
     */
    protected function doGetListeners(){
        return isset($this->listeners) ? $this->listeners : $this->listeners = new SplObjectStorage();
    }

    protected static function doNotify(array $listeners, $subject){
        foreach($listeners as $listener){ 
            $listener->handle($subject);    
        }   
    }  

    protected static function doNotifyUntil(array $listeners, $subject){  
    	$res = NULL;
    	foreach ($listeners as $listener){
        	$res = $listener->handle($subject);
    		if ($res){
            	return $listener;  
          	}
        }
        return $res;
    } 
}

