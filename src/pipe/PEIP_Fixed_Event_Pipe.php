<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Fixed_Event_Pipe 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage pipe 
 * @extends PEIP_Event_Pipe
 * @implements PEIP_INF_Listener, PEIP_INF_Connectable, PEIP_INF_Subscribable_Channel, PEIP_INF_Channel, PEIP_INF_Handler, PEIP_INF_Message_Builder
 */


class PEIP_Fixed_Event_Pipe 
    extends PEIP_Event_Pipe {

    
    /**
     * @access public
     * @param $inputChannel 
     * @return 
     */
    public function setInputChannel(PEIP_INF_Channel $inputChannel){        
        if(isset($this->eventName)){
            $this->connectChannel($inputChannel);   
        }else{
            $this->inputChannel = $inputChannel;    
        }               
    }       
        
    
    /**
     * @access public
     * @param $eventName 
     * @return 
     */
    public function setEventName($eventName){
        if(!isset($this->eventName)){
            $this->eventName = $eventName;
            if($this->inputChannel){
                $this->inputChannel->connect($this->eventName, $this);
            }   
        }
    }   
}
