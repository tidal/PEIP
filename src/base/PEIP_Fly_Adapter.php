<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Fly_Adapter 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage base 
 */




class PEIP_Fly_Adapter {

    
    /**
     * @access public
     * @param $methodMap 
     * @return 
     */
    public function __construct(ArrayAccess $methodMap){        
        $this->methodMap = $methodMap;  
    }
    
    
    /**
     * @access public
     * @param $subject 
     * @return 
     */
    public function setSubject($subject){
        $this->subject = $subject;
        return $this;
    }
    
    
    /**
     * @access public
     * @param $method 
     * @param $arguments 
     * @return 
     */
    public function __call($method, $arguments){
        if(array_key_exists($method, $this->methodMap)){
            return call_user_func_array(array($this->subject, $this->methodMap[$method]), $arguments);
        }
    }
}



