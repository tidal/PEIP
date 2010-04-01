<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Parameter_Collection 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage data 
 * @extends PEIP_Parameter_Holder
 * @implements PEIP_INF_Parameter_Holder, ArrayAccess
 */


class PEIP_Parameter_Collection 
    extends PEIP_Parameter_Holder 
    implements ArrayAccess {

    
    /**
     * @access public
     * @param $offset 
     * @return 
     */
    public function offsetExists($offset){
        return $this->hasParameter($offset);
    }   
    
    
    /**
     * @access public
     * @param $offset 
     * @return 
     */
    public function offsetGet($offset){
        return $this->getParameter($offset);
    }
    
    
    /**
     * @access public
     * @param $name 
     * @return 
     */
    public function offsetUnset($name){
        $this->deleteParameter($name);
    }   

    
    /**
     * @access public
     * @param $offset 
     * @param $name 
     * @return 
     */
    public function offsetSet($offset, $name){
        $this->setParameter($offeset, $name);
    }
    
}