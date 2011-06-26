<?php

namespace PEIP\Data;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * ArrayAccess 
 * Simple implementation of the PHP´s native ArrayAccess interface
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage data 
 * @implements ArrayAccess
 */


class ArrayAccess implements \ArrayAccess {

    protected $values = array();
       
    /**
     * Checks wether a given offset exists
     * 
     * @access public
     * @param mixed $offset the offset  
     * @return 
     */
    public function offsetExists($offset){
        return array_key_exists($name, $this->values);
    }   
      
    /**
     * returns the value for agiven offset
     * 
     * @access public
     * @param mixed $offset the offset 
     * @return 
     */
    public function offsetGet($offset){
        return array_key_exists($name, $this->values) ? $this->values[$offset] : NULL;
    }
     
    /**
     * Deletes the a given offset
     * 
     * @access public
     * @param mixed $offset the offset 
     * @return 
     */
    public function offsetUnset($offset){
        unset($this->values[$offset]);
    }   
  
    /**
     * Sets the value for a given offset
     * 
     * @access public
     * @param mixed $offset the offset 
     * @param mixed $value value for the offset 
     * @return 
     */
    public function offsetSet($offset, $value){
        $this->values[$offset] = $value;
    }

}