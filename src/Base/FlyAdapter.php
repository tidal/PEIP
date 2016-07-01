<?php

namespace PEIP\Base;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * FlyAdapter 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage base 
 */


use PEIP\Data\ArrayAccess;


class FlyAdapter {

    
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



