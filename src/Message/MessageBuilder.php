<?php

namespace PEIP\Message;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * MessageBuilder 
 * Util class to easily create and copy messages
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage message 
 * @implements \PEIP\INF\Message\MessageBuilder, \PEIP\INF\Factory\DedicatedFactory
 */

use PEIP\Factory\DedicatedFactory;
use PEIP\Base\GenericBuilder;

class MessageBuilder 
    implements 
        \PEIP\INF\Message\MessageBuilder,
        \PEIP\INF\Factory\DedicatedFactory {

    protected 
        $messageClass,
        $factory,
        $headers = array(),
        $payload;
       
    /**
     * constructor
     * 
     * @access public
     * @param string $messageClass the message-class to build instances for 
     */
    public function __construct($messageClass = '\PEIP\Message\GenericMessage'){
        $this->messageClass = $messageClass;
        $this->factory = DedicatedFactory::getfromCallable(array($messageClass, 'build'));    
    }
 
    /**
     * copies headers to message to build
     * 
     * @access public
     * @param array $headers the headers to set
     * @return MessageBuilder $this
     */
    public function copyHeaders(array $headers){
        $this->headers = array_merge($this->headers, $headers);
        return $this;       
    }
    
    /**
     * copies headers to message to build if not set allerady
     * 
     * @access public
     * @param array $headers the headers to set
     * @return MessageBuilder $this
     */
    public function copyHeadersIfAbsent(array $headers){
        $this->headers = array_merge($headers, $this->headers);
        return $this;   
    }
       
    /**
     * removes a header from message to build
     * 
     * @access public
     * @param string $headerName the name of the header
     * @return MessageBuilder $this
     */
    public function removeHeader($headerName){
        unset($this->headers[$headerName]);
        return $this;
    }
       
    /**
     * sets a header for the message to build
     * 
     * @access public
     * @param string $headerName the name of the header 
     * @param mixed $headerValue the value for the header
     * @return MessageBuilder $this 
     */
    public function setHeader($headerName, $headerValue){
        $this->headers[$headerName] = $headerValue;
        return $this;   
    }
    
    /**
     * sets all headers for the message to build
     * 
     * @access public
     * @param array $headers the headers to set
     * @return MessageBuilder $this 
     */
    public function setHeaders(array $headers){
        $this->headers = $headers;
        return $this;   
    }
            
    /**
     * returns the headers for the message to build
     * 
     * @access public
     * @return array the headers for the message to build 
     */
    public function getHeaders(){
        return $this->headers;
    }  
        
    /**
     * creates a new message instance with given headers
     * 
     * @access public
     * @param $arguments 
     * @return 
     */
    public function build(array $headers = array()){
        $this->copyHeaders($headers);
        return GenericBuilder::getInstance($this->messageClass)
            ->build(array($this->payload, new \ArrayObject($this->headers)));        
    }
       
    /**
     * sets the content/payload for the message to build
     * 
     * @access public
     * @param mixed $payload payload for the message to build 
     * @return MessageBuilder $this 
     */
    public function setContent($payload){
        $this->payload = $payload;
        return $this;
    }
   
    /**
     * returns a instance of MessageBuilder for given message-class
     * 
     * @access public
     * @static
     * @param string $messageClass the message class to build from the builder 
     * @return MessageBuilder new instance of MessageBuilder 
     */    
    public static function getInstance($messageClass = '\PEIP\Message\GenericMessage'){
        return new  MessageBuilder($messageClass);
    }
  
    /**
     * returns a instance of MessageBuilder for message-class derived from given message
     * 
     * @access public
     * @static
     * @param \PEIP\INF\Message\Message $message the message to get class to build from the builder 
     * @return MessageBuilder new instance of MessageBuilder 
     */      
    public static function getInstanceFromMessage(\PEIP\INF\Message\Message $message){
        return new MessageBuilder(get_class($message));
    }
   
    /**
     * sets the message-class to build new instances for
     * 
     * @access public
     * @param string $messageClass the message-class to build new instances for
     */
    public function setMessageClass($messageClass){
        $this->messageClass = $messageClass;
    }
 
    /**
     * returns the message-class to build new instances for
     * 
     * @access public
     * @return string the message-class to build new instances for
     */
    public function getMessageClass(){
        return $this->messageClass;
    }         
}