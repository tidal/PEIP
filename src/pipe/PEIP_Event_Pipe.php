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
 * Concrete base class for event handling Pipes.
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
     * Sets the input channel for this event-pipe. Contrary to PEIP_Pipe event-pipes
     * listen to a given event on the input-channel and hanle resulting event-objects.
     * 
     * @access public
     * @param PEIP_INF_Channel $inputChannel the input-channel to listen for events. 
     * @return 
     */
    public function setInputChannel(PEIP_INF_Channel $inputChannel){        
        $this->connectChannel($inputChannel);            
    }     
  
    /**
     * Does the message replying logic for the event-pipe.
     * In context of an event-pipe the message is normally a instance of 
     * PEIP_INF_Event representing an event on a channel/pipe. This method
     * looks for a header 'MESSAGE' on the event object. If the header is a
     * message (instance of PEIP_INF_Message) replies with the message.  
     * Implements PEIP_ABS_Reply_Producing_Message_Handler::doReply.
     * 
     * @abstract
     * @access protected
     * @param PEIP_INF_Message $message the message to reply with
     */
    protected function doReply(PEIP_INF_Message $message){
        $headerMessage = $message->getHeader('MESSAGE');
        if($headerMessage instanceof PEIP_INF_Message){
            return $this->replyMessage($headerMessage);
        }
    }
  
    /**
     * Connects the event-pipe to a PEIP_INF_Connectable instance by
     * listening to the event-type registered with this event-pipe.
     * 
     * @access public
     * @param PEIP_INF_Connectable $connectable the connectable to listen to
     * @return 
     */
    public function listen(PEIP_INF_Connectable $connectable){
        return $this->doListen($this->eventName, $connectable);     
    }
       
    /**
     * Disconnects the event-pipe from a PEIP_INF_Connectable instance by
     * listening to the event-type registered with this event-pipe.
     * 
     * @access public
     * @param PEIP_INF_Connectable $connectable the connectable to unlisten  
     * @return 
     */
    public function unlisten(PEIP_INF_Connectable $connectable){
        return $this->doUnlisten($this->eventName, $connectable);       
    }
     
    /**
     * Returns the instances of PEIP_INF_Connectable the event-pipe is litening to
     * 
     * @access public
     * @return array array of PEIP_INF_Connectable instances
     */
    public function getConnected(){
        return $this->doGetConnected();
    }
       
    /**
     * Disconnects a PEIP_INF_Channel instance from the event-pipe
     * 
     * @access public
     * @param PEIP_INF_Channel $channel PEIP_INF_Channel instance to disconnect from
     * @return 
     */
    public function disconnectChannel(PEIP_INF_Channel $channel){
        $this->disconnectInputChannel();        
        $this->inputChannel = $channel;         
        $this->connectInputChannel();       
    }
    
    /**
     * Connects the registered input-channel to this event-pipe by
     * listening to the event-type registered with this event-pipe.
     * 
     * @access protected
     * @return 
     */
    protected function connectInputChannel(){
        if($this->inputChannel && $this->eventName){
            $this->inputChannel->connect($this->eventName, $this);
        }   
    }
       
    /**
     * Disconnects the registered input-channel from this event-pipe by
     * unlistening to the event-type registered with this event-pipe.
     * 
     * @access protected
     * @return 
     */
    protected function disconnectInputChannel(){
        if($this->inputChannel && $this->eventName){
            $this->inputChannel->disconnect($this->eventName, $this);
        }       
    }
       
    /**
     * Registers the event-name this event-pipe should listen to.
     * 
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
