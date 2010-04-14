<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Event_Builder 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage event 
 */


class PEIP_Event_Builder {

    protected $eventClass,
        $defaultParameters = array();
    
    protected static $instances = array();      
           
    /**
     * constructor
     * 
     * @access public
     * @param string $eventClass the event-class the builder shall create instances for 
     * @param array $defaultHeaders default headers for the created events 
     */
    public function __construct($eventClass = 'PEIP_Event', array $defaultHeaders = array()){
        $this->eventClass = $eventClass;
        $this->defaultParameters = $defaultParameters;
    }

    /**
     * returns a instance of PEIP_Event_Builder for a given event-class
     * 
     * @access public
     * @param string $eventClass the event-class the builder shall create instances for 
     * @return PEIP_Event_Builder the instance of PEIP_Event_Builder for the given event-class 
     */    
    public static function getInstance($eventClass = false){
        $eventClass = $eventClass ? $eventClass : 'PEIP_Event';
        return isset(self::$instances[$eventClass]) 
            ? self::$instances[$eventClass] 
            : self::$instances[$eventClass] = new PEIP_Event_Builder($eventClass);
    }
      
    /**
     * creates an event-object from given arguments
     * 
     * @access public
     * @param mixed $subject the subject for the event
     * @param string $name the name of the event
     * @param array $headers the headers for the event 
     * @return 
     */
    public function build($subject, $name, array $headers = array()){
        $parameters = array_merge($this->defaultParameters, $parameters);
        return $event = new $this->eventClass($subject, $name, $parameters);
    }
    
    /**
     * creates an event-object and dispatches it through given dispatcher
     * 
     * @access public
     * @param PEIP_Object_Event_Dispatcher $dispatcher the dispatcher to dispatch the event 
     * @param mixed $subject the subject for the event
     * @param string $name the name of the event
     * @param array $parameters the headers for the event
     * @return 
     */
    public function buildAndDispatch(PEIP_Object_Event_Dispatcher $dispatcher, $subject, $name, array $parameters = array()){
        $event = $this->build($subject, $name, $parameters);    
        return $dispatcher->notify($name, $event);          
    }
}