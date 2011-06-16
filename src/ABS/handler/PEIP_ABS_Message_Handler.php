<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_ABS_Message_Handler 
 * Base class for all message handling classes.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage handler 
 * @implements PEIP_INF_Handler
 */

abstract class PEIP_ABS_Message_Handler
    extends PEIP_ABS_Connectable
    implements PEIP_INF_Handler {
    
    protected 
        $inputChannel,
        $unwrapEvents = false;
           
    /**
     * Handles a message. Delegates the handling of the message to 
     * abstract 'doHandle' method which must be implemented by extending classes.
     * 
     * @see PEIP_ABS_Message_Handler::doHandle
     * @implements PEIP_INF_Handler
     * @access public
     * @param object $message the message to handle
     * @return 
     */
    public function handle($message){
         $this->doHandle($this->getMessageFromObject($message));      
    }
   
    /**
     * Sets the input channel for the message handler.
     * Delegates connecting of input-channel to protected method 'doSetInputChannel',
     * which can be overwritten by extending classes.
     * 
     * @see PEIP_ABS_Message_Handler::doSetInputChannel
     * @access public
     * @param PEIP_INF_Channel $inputChannel the input-channel
     * @return PEIP_ABS_Message_Handler $this;
     */
    public function setInputChannel(PEIP_INF_Channel $inputChannel){
        $this->doSetInputChannel($inputChannel);
        return $this;
    }
    
    /**
     * Connects the handler to the input channel. 
     * When input-channel is instance of PEIP_INF_Subscribable_Channel,
     * the handler subscribes to the channel.
     * When input-channel is instance of PEIP_INF_Pollable_Channel, the
     * handler listens to the 'preSend' event of the channel and receives
     * a message, when the event occures.
     * 
     * @access protected
     * @param PEIP_INF_Channel $inputChannel the input-channel to connect the handler to
     * @return 
     */
    protected function doSetInputChannel(PEIP_INF_Channel $inputChannel){
        $this->inputChannel = $inputChannel;    
        if($this->inputChannel instanceof PEIP_INF_Subscribable_Channel){
                $this->inputChannel->subscribe($this);
        }else{          
            $this->unwrapEvents = true;
            $this->inputChannel->connect('postSend', $this);
        }  
    }
  
    protected function getMessageFromObject($object){ 
        $content = $object->getContent();
        if($this->unwrapEvents
            && $object instanceof PEIP_INF_Event
            && $object->getName() == 'postSend'
            && $object->hasHeader(PEIP_Pipe::HEADER_MESSAGE)
            && $content instanceof PEIP_INF_Pollable_Channel
         ){
            $object = $content->receive();
        }
        if (!($object instanceof PEIP_INF_Message)) {
            throw new Exception('Could not retrieve Message from Message-Argument'.print_r($objec, 1));
        }
        return $object;
    }

      
    /**
     * Returns the input-channel for this handler.
     * 
     * @access public
     * @return PEIP_INF_Channel input-channel for this handler
     */
    public function getInputChannel(){
        return $this->inputChannel;
    }   
      
    /**
     * Does the message handling logic for the handler. 
     * Must be implemented by extending classes.
     * 
     * @abstract
     * @access protected
     * @param PEIP_INF_Message $message the message to handle
     */
    abstract protected function doHandle(PEIP_INF_Message $message);
    
}

