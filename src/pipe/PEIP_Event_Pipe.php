<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Event_Pipe 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage pipe 
 * @extends PEIP_ABS_Event_Pipe
 * @implements PEIP_INF_Message_Builder, PEIP_INF_Handler, PEIP_INF_Channel, PEIP_INF_Subscribable_Channel, PEIP_INF_Connectable, PEIP_INF_Listener
 */


class PEIP_Event_Pipe 
    extends PEIP_ABS_Event_Pipe 
    implements PEIP_INF_Listener {

    protected 
        $eventName; 
    
    
    /**
     * @access public
     * @param $inputChannel 
     * @return 
     */
    public function setInputChannel(PEIP_INF_Channel $inputChannel){        
        $this->connectChannel($inputChannel);            
    }     

    
    /**
     * @access protected
     * @param $message 
     * @return 
     */
    protected function doReply(PEIP_INF_Message $message){
        $headerMessage = $message->getHeader('MESSAGE');
        if($headerMessage instanceof PEIP_INF_Message){
            return $this->replyMessage($headerMessage);
        }
    }

    
    /**
     * @access public
     * @param $connectable 
     * @return 
     */
    public function listen(PEIP_INF_Connectable $connectable){
        return $this->doListen($this->eventName, $connectable);     
    }
    
    
    /**
     * @access public
     * @param $connectable 
     * @return 
     */
    public function unlisten(PEIP_INF_Connectable $connectable){
        return $this->doUnlisten($this->eventName, $connectable);       
    }
    
    
    /**
     * @access public
     * @return 
     */
    public function getConnected(){
        return $this->doGetConnected();
    }
    
    
    /**
     * @access public
     * @param $channel 
     * @return 
     */
    public function connectChannel(PEIP_INF_Channel $channel){
        $this->disconnectInputChannel();        
        $this->inputChannel = $channel;         
        $this->connectInputChannel();       
    }        
    
    /**
     * @access public
     * @param $channel 
     * @return 
     */
    public function disconnectChannel(PEIP_INF_Channel $channel){
        $this->disconnectInputChannel();              
    }
    
    /**
     * @access protected
     * @return 
     */
    protected function connectInputChannel(){
        if($this->inputChannel && $this->eventName){
            $this->inputChannel->connect($this->eventName, $this);
        }   
    }
    
    
    /**
     * @access protected
     * @return 
     */
    protected function disconnectInputChannel(){
        if($this->inputChannel && $this->eventName){
            $this->inputChannel->disconnect($this->eventName, $this);
        }       
    }
    
    
    /**
     * @access public
     * @param $eventName 
     * @return 
     */
    public function setEventName($eventName){
        $this->disconnectInputChannel();
        $this->eventName = $eventName;
        $this->connectInputChannel();
    }
        
}
