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
     * @access public
     * @param $content 
     * @param $headers 
     * @return 
     */
    public function __construct($content, ArrayAccess $headers = NULL){
        $this->doSetContent($content);      
        if($headers){
            $this->headers = $headers;
        }           
    }

    
    /**
     * @access protected
     * @param $content 
     * @return 
     */
    protected function doSetContent($content){
        $this->content = $content;
    }
    
    
    /**
     * @access public
     * @return 
     */
    
    /**
     * @access public
     * @param $name 
     * @return 
     */
    public function getHeaders(){
        return $this->headers;
    }

    
    /**
     * @access public
     * @param $name 
     * @return 
     */
    public function getHeader($name){
        return $this->headers[$name];
    }
    
    
    /**
     * @access public
     * @param $name 
     * @return 
     */
    public function hasHeader($name){
        return (bool)$this->headers[$name];
    }
    
    public static function build(array $arguments = array()){
        return PEIP_Generic_Builder::getInstance('PEIP_Generic_Message')->build($arguments);    
    }   
    
} 