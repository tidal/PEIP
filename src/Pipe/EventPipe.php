<?php

namespace PEIP\Pipe;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * EventPipe 
 * Concrete base class for event handling Pipes.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage pipe 
 * @extends \PEIP\ABS\Pipe\EventPipe
 * @implements \PEIP\INF\Message\MessageBuilder, \PEIP\INF\Handler\Handler, \PEIP\INF\Channel\Channel, \PEIP\INF\Channel\SubscribableChannel, \PEIP\INF\Event\Connectable, \PEIP\INF\Event\Listener
 */


class EventPipe 
    extends \PEIP\ABS\Pipe\EventPipe 
    implements \PEIP\INF\Event\Listener {

    protected 
        $eventName; 
       
    public function connectChannel(\PEIP\INF\Channel\Channel $inputChannel){
        $this->inputChannel = $inputChannel;
        
    }



    /**
     * Sets the input channel for this event-pipe. Contrary to Pipe event-pipes
     * listen to a given event on the input-channel and hanle resulting event-objects.
     * 
     * @access public
     * @param \PEIP\INF\Channel\Channel $inputChannel the input-channel to listen for events. 
     * @return 
     */
    public function setInputChannel(\PEIP\INF\Channel\Channel $inputChannel){        
        $this->connectChannel($inputChannel);            
    }     
  
    /**
     * Does the message replying logic for the event-pipe.
     * In context of an event-pipe the message is normally a instance of 
     * \PEIP\INF\Event\Event representing an event on a channel/pipe. This method
     * looks for a header 'MESSAGE' on the event object. If the header is a
     * message (instance of \PEIP\INF\Message\Message) replies with the message.  
     * Implements PEIP\ABS\Handler\ReplyProducingMessageHandler::doReply.
     * 
     * @abstract
     * @access protected
     * @param \PEIP\INF\Message\Message $message the message to reply with
     */
    protected function doReply(\PEIP\INF\Message\Message $message){
        $headerMessage = $message->getHeader('MESSAGE');
        if($headerMessage instanceof \PEIP\INF\Message\Message){
            return $this->replyMessage($headerMessage);
        }
    }
  
    /**
     * Connects the event-pipe to a \PEIP\INF\Event\Connectable instance by
     * listening to the event-type registered with this event-pipe.
     * 
     * @access public
     * @param \PEIP\INF\Event\Connectable $connectable the connectable to listen to
     * @return 
     */
    public function listen(\PEIP\INF\Event\Connectable $connectable){
        return $this->doListen($this->eventName, $connectable);     
    }
       
    /**
     * Disconnects the event-pipe from a \PEIP\INF\Event\Connectable instance by
     * listening to the event-type registered with this event-pipe.
     * 
     * @access public
     * @param \PEIP\INF\Event\Connectable $connectable the connectable to unlisten  
     * @return 
     */
    public function unlisten(\PEIP\INF\Event\Connectable $connectable){
        return $this->doUnlisten($this->eventName, $connectable);       
    }
     
    /**
     * Returns the instances of \PEIP\INF\Event\Connectable the event-pipe is litening to
     * 
     * @access public
     * @return array array of \PEIP\INF\Event\Connectable instances
     */
    public function getConnected(){
        return $this->doGetConnected();
    }
       
    /**
     * Disconnects a \PEIP\INF\Channel\Channel instance from the event-pipe
     * 
     * @access public
     * @param \PEIP\INF\Channel\Channel $channel \PEIP\INF\Channel\Channel instance to disconnect from
     * @return 
     */
    public function disconnectChannel(\PEIP\INF\Channel\Channel $channel){
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
