<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Generic_Message 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage message 
 * @extends PEIP_ABS_Container
 * @implements PEIP_INF_Container, PEIP_INF_Message, PEIP_INF_Buildable
 */

class PEIP_Generic_Message 
    extends PEIP_ABS_Container
    implements 
        PEIP_INF_Message, 
        PEIP_INF_Buildable {

    protected $payload;
    
    protected $headers; 
           
    /**
     * constructor
     * 
     * @access public
     * @param mixed $content The content/payload of the message 
     * @param ArrayAccess $headers ArrayAccess object of headers as key/value pairs
     */
    public function __construct($content, ArrayAccess $headers = NULL){
        $this->doSetContent($content);      
        if($headers){
            $this->headers = $headers;
        }           
    }
  
    /**
     * sets content/payload of message - to be overwritten by derived classes
     * 
     * @access protected
     * @param mixed $content The content/payload of the message 
     */
    protected function doSetContent($content){
        $this->content = $content;
    }
    
    /**
     * returns all headers of the message
     * 
     * @access public
     * @return ArrayAccess ArrayAccess object of headers
     */
    public function getHeaders(){
        return $this->headers;
    }
  
    /**
     * returns one specific header of the message
     * 
     * @access public
     * @param string $name the name of the header  
     * @return mixed the value of the header
     */
    public function getHeader($name){
        return $this->headers[$name];
    }
     
    /**
     * checks wether a specific header is set on the message
     * 
     * @access public
     * @param string $name the name of the header
     * @return boolean wether the header is set
     */
    public function hasHeader($name){
        return isset($this->headers[$name]);
    }
   
    /**
     * Provides a static build method to create new Instances of this class.
     * Implements PEIP_INF_Buildable
     * 
     * @static
     * @access public
     * @implements PEIP_INF_Buildable
     * @param array $arguments argumends for the constructor
     * @return PEIP_Generic_Message new class instance
     */    
    public static function build(array $arguments = array()){
        return PEIP_Generic_Builder::getInstance('PEIP_Generic_Message')->build($arguments);    
    }     
} 