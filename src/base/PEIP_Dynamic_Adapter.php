<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Dynamic_Adapter 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage base 
 */





class PEIP_Dynamic_Adapter {

    protected $methodMap;
    
    protected $subject;
    
    
    /**
     * @access public
     * @param $methodMap 
     * @param $subject 
     * @return 
     */
    public function __construct(ArrayAccess $methodMap, $subject){      
        $this->methodMap = $methodMap;
        $this->subject = $subject;      
    }

    
    /**
     * @access public
     * @param $method 
     * @param $arguments 
     * @return 
     */
    public function __call($method, array $arguments){
        if(array_key_exists($method, $this->methodMap)){
            return call_user_func_array(array($this->subject, $this->methodMap[$method]), $arguments);
        }
    }
}