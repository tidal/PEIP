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

    protected $messageClass;
    
    protected $factory;
    
    protected $headers = array();
    
    protected  $payload;
    
    
    /**
     * @access public
     * @param $messageClass 
     * @return 
     */
    public function __construct($messageClass = 'PEIP_Generic_Message'){
        $this->messageClass = $messageClass;
        $this->factory = PEIP_Dedicated_Factory::getfromCallable(array($messageClass, 'build'));    
    }

    
    /**
     * @access public
     * @param $headers 
     * @return 
     */
    public function copyHeaders(array $headers){
        array_merge($this->headers, $headers);
        return $this;       
    }
    
    
    /**
     * @access public
     * @param $headers 
     * @return 
     */
    
    /**
     * @access public
     * @param $headers 
     * @return 
     */
    public function copyHeadersIfAbsent (array $headers){
        array_merge($headers, $this->headers);
        return $this;   
    }
    
    
    /**
     * @access public
     * @param $headerName 
     * @return 
     */
    public function removeHeader($headerName){
        unset($this->header[$headerName]);
        return $this;
    }
    
    
    /**
     * @access public
     * @param $headerName 
     * @param $headerValue 
     * @return 
     */
    public function setHeader($headerName, $headerValue){
        $this->header[$headerName] = $headerValue;
        return $this;   
    }
    
    
    /**
     * @access public
     * @param $headerName 
     * @param $headerValue 
     * @return 
     */
    
    /**
     * @access public
     * @param $headers 
     * @return 
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
     * @access public
     * @param $payload 
     * @return 
     */
    public function setContent($payload){
        $this->payload = $payload;
        return $this;
    }
    
    public static function getInstance($messageClass = 'PEIP_Generic_Message'){
        return new  PEIP_Message_Builder($messageClass);
    }
    
    public static function createFromMessage(PEIP_INF_Message $message){
        return new PEIP_Message_Builder(get_class($message));
    }

    
    /**
     * @access public
     * @param $messageClass 
     * @return 
     */
    public function setMessageClass($messageClass){
        $this->messageClass = $messageClass;
    }

    
    /**
     * @access public
     * @return 
     */
    public function getMessageClass(){
        return $this->messageClass;
    }       
    
}