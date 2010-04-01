<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Store 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage data 
 * @extends PEIP_Array_Access
 * @implements ArrayAccess, PEIP_INF_Store
 */




class PEIP_Store extends PEIP_Array_Access implements PEIP_INF_Store {

    
    /**
     * @access public
     * @param $key 
     * @param $value 
     * @return 
     */
    public function setValue($key, $value){
        return $this->offsetSet($key, $value);
    }
    
    /**
     * @access public
     * @param $key 
     * @return 
     */
    public function getValue($key){
        return $this->offsetGet($key, $value);
    }

    
    /**
     * @access public
     * @param $key 
     * @return 
     */
    public function deleteValue($key){
        return $this->offsetUnset($key);
    }
    
    
    /**
     * @access public
     * @param $key 
     * @return 
     */
    public function hasValue($key){
        return $this->offsetExists($key);
    }   

    
    /**
     * @access public
     * @param $key 
     * @param $value 
     * @return 
     */
    
    /**
     * @access public
     * @param $values 
     * @return 
     */
    public function setValues(array $values){
        $this->values = $values;        
    }

    
    /**
     * @access public
     * @param $key 
     * @return 
     */
    
    /**
     * @access public
     * @return 
     */
    public function getValues(){
        return $this->values;
    }

    
    /**
     * @access public
     * @param $values 
     * @return 
     */
    public function addValues(array $values){
        array_merge($this->values, $values);
    }   
}