<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * PEIP_Message_Builder 
 * Util class to easily create and copy messages
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage message 
 * @implements PEIP_INF_Message_Builder, PEIP_INF_Dedicated_Factory
 */

class PEIP_Message_Builder 
    implements 
        PEIP_INF_Message_Builder,
        PEIP_INF_Dedicated_Factory {

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
    public function __construct($messageClass = 'PEIP_Generic_Message'){
        $this->messageClass = $messageClass;
        $this->factory = PEIP_Dedicated_Factory::getfromCallable(array($messageClass, 'build'));    
    }
 
    /**
     * copies headers to message to build
     * 
     * @access public
     * @param array $headers the headers to set
     * @return PEIP_Message_Builder $this
     */
    public function copyHeaders(array $headers){
        array_merge($this->headers, $headers);
        return $this;       
    }
    
    /**
     * copies headers to message to build if not set allerady
     * 
     * @access public
     * @param array $headers the headers to set
     * @return PEIP_Message_Builder $this
     */
    public function copyHeadersIfAbsent (array $headers){
        array_merge($headers, $this->headers);
        return $this;   
    }
       
    /**
     * removes a header from message to build
     * 
     * @access public
     * @param string $headerName the name of the header
     * @return PEIP_Message_Builder $this
     */
    public function removeHeader($headerName){
        unset($this->header[$headerName]);
        return $this;
    }
       
    /**
     * sets a header for the message to build
     * 
     * @access public
     * @param string $headerName the name of the header 
     * @param mixed $headerValue the value for the header
     * @return PEIP_Message_Builder $this 
     */
    public function setHeader($headerName, $headerValue){
        $this->header[$headerName] = $headerValue;
        return $this;   
    }
    
    /**
     * sets all headers for the message to build
     * 
     * @access public
     * @param array $headers the headers to set
     * @return PEIP_Message_Builder $this 
     */
    public function setHeaders(array $headers){
        $this->headers = $headers;
        return $this;   
    }
      
    /**
     * @access public
     * @param $arguments 
     * @return 
     */
    public function build(array $arguments = array()){
        $this->copyHeaders($arguments);
        return PEIP_Generic_Builder::getInstance($this->messageClass)
            ->build(array($this->payload, new ArrayObject($this->headers)));        
    }
       
    /**
     * sets the content/payload for the message to build
     * 
     * @access public
     * @param mixed $payload payload for the message to build 
     * @return PEIP_Message_Builder $this 
     */
    public function setContent($payload){
        $this->payload = $payload;
        return $this;
    }
   
    /**
     * returns a instance of PEIP_Message_Builder for given message-class
     * 
     * @access public
     * @static
     * @param string $messageClass the message class to build from the builder 
     * @return PEIP_Message_Builder new instance of PEIP_Message_Builder 
     */    
    public static function getInstance($messageClass = 'PEIP_Generic_Message'){
        return new  PEIP_Message_Builder($messageClass);
    }
  
    /**
     * returns a instance of PEIP_Message_Builder for message-class derived from given message
     * 
     * @access public
     * @static
     * @param PEIP_INF_Message $message the message to get class to build from the builder 
     * @return PEIP_Message_Builder new instance of PEIP_Message_Builder 
     */      
    public static function createFromMessage(PEIP_INF_Message $message){
        return new PEIP_Message_Builder(get_class($message));
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