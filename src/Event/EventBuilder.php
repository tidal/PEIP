<?php

namespace PEIP\Event;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * EventBuilder
 * Factory class to create event-objects 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage event 
 */

use PEIP\Dispatcher\ObjectEventDispatcher;



class EventBuilder {

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
    public function __construct($eventClass = '\PEIP\Event\Event', array $defaultHeaders = array()){
        $this->eventClass = $eventClass;
        $this->defaultParameters = $defaultHeaders;
    }

    /**
     * returns a instance of EventBuilder for a given event-class
     * 
     * @access public
     * @param string $eventClass the event-class the builder shall create instances for 
     * @return EventBuilder the instance of EventBuilder for the given event-class 
     */    
    public static function getInstance($eventClass = '\PEIP\Event\Event'){ 

        return isset(self::$instances[$eventClass]) 
            ? self::$instances[$eventClass] 
            : self::$instances[$eventClass] = new EventBuilder(
                \PEIP\Util\Test::ensureImplements($eventClass, '\PEIP\INF\Event\Event')
        );
    }
      
    /**
     * creates an event-object from given arguments
     * 
     * @access public
     * @param mixed $subject the subject for the event
     * @param string $name the name of the event
     * @param array $headers the headers for the event 
     * @return object event instance
     */
    public function build($subject, $name, array $headers = array()){

        return new $this->eventClass(
            $subject,
            $name,
            array_merge($this->defaultParameters, $headers)
        );
    }
    
    /**
     * creates an event-object and dispatches it through given dispatcher
     * 
     * @access public
     * @param ObjectEventDispatcher $dispatcher the dispatcher to dispatch the event 
     * @param mixed $subject the subject for the event
     * @param string $name the name of the event
     * @param array $parameters the headers for the event
     * @return 
     */
    public function buildAndDispatch(ObjectEventDispatcher $dispatcher, $subject, $name, array $headers = array()){
  
        return $dispatcher->notify(
            $name,
            $this->build($subject, $name, $headers)
        );
    }
}