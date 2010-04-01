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
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage pipe 
 * @extends PEIP_Pipe
 * @implements PEIP_INF_Connectable, PEIP_INF_Subscribable_Channel, PEIP_INF_Channel, PEIP_INF_Handler, PEIP_INF_Message_Builder
 */


abstract class PEIP_ABS_Event_Pipe  
    extends PEIP_Pipe {

    
    protected 
        $connections = array(); 
          



    
    /**
     * @access protected
     * @param $eventName 
     * @param $connectable 
     * @return 
     */
    protected function doListen($eventName, PEIP_INF_Connectable $connectable){
        if(!$connectable->hasListener($eventName, $this)){
            $connectable->connect($eventName, $this);
            $this->connections[spl_object_hash($connectable)] = $connectable;   
        }   
    }
    
    
    /**
     * @access protected
     * @param $eventName 
     * @param $connectable 
     * @return 
     */
    protected function doUnlisten($eventName, PEIP_INF_Connectable $connectable){
        if(!$connectable->hasListener($eventName, $this)){
            $connectable->disconnect($eventName, $this);
            unset($this->connections[spl_object_hash($connectable)]);   
        }   
    }

    
    /**
     * @access public
     * @return 
     */
    public function doGetConnected(){
        return array_values($this->connections);
    }
    
}