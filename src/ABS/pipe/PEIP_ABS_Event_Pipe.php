<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_ABS_Event_Pipe 
 * Abstract base class for all event handling Pipes.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage pipe 
 * @extends PEIP_Pipe
 * @abstract
 * @implements PEIP_INF_Connectable, PEIP_INF_Subscribable_Channel, PEIP_INF_Channel, PEIP_INF_Handler, PEIP_INF_Message_Builder
 */

abstract class PEIP_ABS_Event_Pipe  
    extends PEIP_Pipe {
   
    protected 
        $connections = array(); 
            
    /**
     * Connects the event-pipe to a given PEIP_INF_Connectable instance by listening
     * to a given event on the connectable.
     * 
     * @access protected
     * @param string $eventName name of the event to listen to 
     * @param PEIP_INF_Connectable $connectable instance of PEIP_INF_Connectable to listen to 
     */
    protected function doListen($eventName, PEIP_INF_Connectable $connectable){
        if(!$connectable->hasListener($eventName, $this)){
            $connectable->connect($eventName, $this);
            $this->connections[spl_object_hash($connectable)] = $connectable;   
        }   
    }
        
    /**
     * Disonnects the event-pipe from listening to a given event on a PEIP_INF_Connectable instance.
     * 
     * @access protected
     * @param string $eventName name of the event to unlisten 
     * @param PEIP_INF_Connectable $connectable instance of PEIP_INF_Connectable to unlisten to 
     */
    protected function doUnlisten($eventName, PEIP_INF_Connectable $connectable){
        if(!$connectable->hasListener($eventName, $this)){
            $connectable->disconnect($eventName, $this);
            unset($this->connections[spl_object_hash($connectable)]);   
        }   
    }
   
    /**
     * Returns the instances of PEIP_INF_Connectable the event-pipe is litening to
     * 
     * @access public
     * @return array array of PEIP_INF_Connectable instances
     */
    public function doGetConnected(){
        return array_values($this->connections);
    }
    
}