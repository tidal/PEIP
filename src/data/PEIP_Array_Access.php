<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Array_Access 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage data 
 * @implements ArrayAccess
 */



class PEIP_Array_Access implements ArrayAccess {

    protected $values = array();
    
    
    
    /**
     * @access public
     * @param $offset 
     * @return 
     */
    public function offsetExists($offset){
        return array_key_exists($name, $this->values);
    }   
    
    
    /**
     * @access public
     * @param $offset 
     * @return 
     */
    public function offsetGet($offset){
        return array_key_exists($name, $this->values) ? $this->values[$offset] : NULL;
    }
    
    
    /**
     * @access public
     * @param $name 
     * @return 
     */
    public function offsetUnset($name){
        unset($this->values[$offset]);
    }   

    
    /**
     * @access public
     * @param $offset 
     * @param $value 
     * @return 
     */
    public function offsetSet($offset, $value){
        $this->values[$offset] = $value;
    }

}