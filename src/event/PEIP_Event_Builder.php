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
        $defaultParameters;
    
    protected static $instances = array();      
        
    
    /**
     * @access public
     * @param $eventClass 
     * @param $defaultParameters 
     * @return 
     */
    public function __construct($eventClass, array $defaultParameters = array()){
        $this->eventClass = $eventClass;
        $this->defaultParameters = $defaultParameters;
    }

    public static function getInstance($eventClass = false){
        $eventClass = $eventClass ? $eventClass : 'PEIP_Event';
        return isset(self::$instances[$eventClass]) 
            ? self::$instances[$eventClass] 
            : self::$instances[$eventClass] = new PEIP_Event_Builder($eventClass);
    }
    
    
    
    /**
     * @access public
     * @param $subject 
     * @param $name 
     * @param $parameters 
     * @return 
     */
    public function build($subject, $name, array $parameters = array()){
        $parameters = array_merge($this->defaultParameters, $parameters);
        return $event = new $this->eventClass($subject, $name, $parameters);
    }

    
    /**
     * @access public
     * @param $subject 
     * @param $name 
     * @param $parameters 
     * @return 
     */
    
    /**
     * @access public
     * @param $dispatcher 
     * @param $subject 
     * @param $name 
     * @param $parameters 
     * @return 
     */
    public function buildAndDispatch(PEIP_Object_Event_Dispatcher $dispatcher, $subject, $name, array $parameters = array()){
        $event = $this->build($subject, $name, $parameters);    
        return $dispatcher->notify($name, $event);          
    }



}