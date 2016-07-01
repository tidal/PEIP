<?php

namespace PEIP\ABS\Handler;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP\ABS\Handler\ReplyProducingMessageHandler 
 * Base class for all message handlers that can reply to a message
 * on an output-channel.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage handler 
 * @extends \PEIP\ABS\Handler\MessageHandler
 * @implements \PEIP\INF\Handler\Handler, \PEIP\INF\Message\MessageBuilder
 */

use PEIP\Message\MessageBuilder;

abstract class ReplyProducingMessageHandler
    extends \PEIP\ABS\Handler\MessageHandler {
    
    protected 
        $outputChannel,
        $messageClass = '\PEIP\Message\GenericMessage',
        $replyChannelHeaders = array('REPLY_CHANNEL');
  
    /**
     * Sets the output-channel for the message handler.
     * Delegates connecting of input-channel to protected method 'doSetOutputChannel',
     * which can be overwritten by extending classes.
     * 
     * @see \PEIP\ABS\Handler\MessageHandler::doSetOutputChannel
     * @access public
     * @param \PEIP\INF\Channel\Channel $outputChannel the output-channel
     * @return \PEIP\ABS\Handler\MessageHandler $this;
     */
    public function setOutputChannel(\PEIP\INF\Channel\Channel $outputChannel){
        $this->doSetOutputChannel($outputChannel);
        return $this;
    }   
   
    /**
     * Connects the handler to the output-channel. 
     * 
     * @access protected
     * @param \PEIP\INF\Channel\Channel $inputChannel the output-channel to connect the handler to
     * @return 
     */
    protected function doSetOutputChannel(\PEIP\INF\Channel\Channel $outputChannel){
        $this->outputChannel = $outputChannel;
    }
       
    /**
     * Returns the output-channel for this handler.
     * 
     * @access public
     * @return \PEIP\INF\Channel\Channel output-channel for this handler
     */
    public function getOutputChannel(){
        return $this->outputChannel;
    }

    /**
     * Resolves the output-channel for a message.
     * Returns default output-channel if no reply-channel is found in
     * the message headers.
     * 
     * @see PEIP\ABS\Handler\ReplyProducingMessageHandler::resolveReplyChannel
     * @access protected
     * @param \PEIP\INF\Message\Message $message the message to resolve output-channel for
     * @return \PEIP\INF\Channel\Channel the output-channel for the message
     */    
    protected function doGetOutputChannel(\PEIP\INF\Message\Message $message){
        $replyChannel = $this->resolveReplyChannel($message);
        return $replyChannel ? $replyChannel : $this->getOutputChannel();       
    }

    /**
     * Resolves a reply-channel for a message.
     * Looks for a reply-channel header in the message (default: 'REPLY_CHANNEL')
     * and returns it�s value, if found.
     * 
     * @access protected
     * @param \PEIP\INF\Message\Message $message 
     * @return \PEIP\INF\Channel\Channel the reply-channel if found
     */     
    protected function resolveReplyChannel(\PEIP\INF\Message\Message $message){
        foreach($this->replyChannelHeaders as $header){
            if($message->hasHeader($header)){
                return $message->getHeader($header);
            }
        }
        return NULL;
    }
        
    /**
     * Sends a reply-message on a appropriate channel.
     * Argument $content can be either a message (\PEIP\INF\Message\Message) or
     * the content/payload to create a new message for.
     * 
     * @see PEIP\ABS\Handler\ReplyProducingMessageHandler::ensureMessage
     * @see PEIP\ABS\Handler\ReplyProducingMessageHandler::doGetOutputChannel
     * @access protected
     * @param mixed $content \PEIP\INF\Message\Message or content/payload for new message 
     */
    protected function replyMessage($content){
        $message = $this->ensureMessage($content);      
        $this->doGetOutputChannel($message)->send($message);      
    }
   
    /**
     * Ensures to return a valid \PEIP\INF\Message\Message instance.
     * If argument $message is not instance of \PEIP\INF\Message\Message, creates
     * a new message with $message as content/payload.
     * 
     * @access protected
     * @param mixed $message \PEIP\INF\Message\Message or content/payload for new message
     * @return \PEIP\INF\Message\Message
     */
    protected function ensureMessage($message){
        return ($message instanceof \PEIP\INF\Message\Message) ? $message : $this->buildMessage($message);   
    }
       
    /**
     * Creates a new message instance with given content as content/payload.
     * Delegates creation of message to instance of MessageBuilder.
     * 
     * @access protected
     * @param mixed $content content/payload for the message
     * @return \PEIP\INF\Message\Message
     * @see MessageBuilder
     */
    protected function buildMessage($content){
        return $this->getMessageBuilder()->setContent($content)->build();   
    }   
       
    /**
     * Returns the a instance of MessageBuilder for the registered message class
     * to create reply-messages from.
     * 
     * @access protected
     * @return MessageBuilder builder for the registered message class
     */
    protected function getMessageBuilder(){
        return isset($this->messageBuilder) && ($this->messageBuilder->getMessageClass() == $this->getMessageClass())
            ? $this->messageBuilder
            : $this->messageBuilder = MessageBuilder::getInstance($this->messageClass);
    }
      
    /**
     * Sets the message-class to create reply-messages from.
     * 
     * @access public
     * @param string $messageClass name of the message-class to create reply-messages from. 
     * @return PEIP\ABS\Handler\ReplyProducingMessageHandler $this
     */
    public function setMessageClass($messageClass){
        $this->messageClass = $messageClass;
        return $this;
    }
   
    /**
     * Returns the message-class to create reply-messages from.
     * 
     * @access public
     * @return string name of the message-class to create reply-messages from. 
     */
    public function getMessageClass(){
        return $this->messageClass;
    }       

    /**
     * Adds the name of a message-header to look for a reply-channel. 
     * 
     * @access public
     * @param string $headerName name of a message-header to look for a reply-channel
     * @return void
     */
    public function addReplyChannelHeader($headerName){
        $this->replyChannelHeaders[] = $headerName;
    }
    
    /**
     * Sets all message-header names to look for a reply-channel.
     * 
     * @access public
     * @param array $headerNames array of message-header names to look for a reply-channel
     * @return PEIP\ABS\Handler\ReplyProducingMessageHandler $this
     */
    public function setReplyChannelHeaders(array $headerNames){
        $this->replyChannelHeaders = $headerNames;
        return $this;
    } 

    /**
     * Returns all message-header names to look for a reply-channel.
     * 
     * @access public
     * @return array array of message-header names to look for a reply-channel
     */
    public function getReplyChannelHeaders(){
        return $this->replyChannelHeaders;
    }
         
    /**
     * Does the message handling logic for the handler. 
     * Implements abstract method of \PEIP\ABS\Handler\MessageHandler.
     * Delegates the handling of the message to abstract 'doReply' 
     * method which must be implemented by extending classes.
     * 
     * @access protected
     * @param \PEIP\INF\Message\Message $message 
     * @return 
     */
    protected function doHandle(\PEIP\INF\Message\Message $message){
        return $this->doReply($message);
    }
       
    /**
     * Does the message replying logic for the handler. 
     * Must be implemented by extending classes.
     * 
     * @abstract
     * @access protected
     * @param \PEIP\INF\Message\Message $message the message to reply with
     */
    abstract protected function doReply(\PEIP\INF\Message\Message $message);
       
}
