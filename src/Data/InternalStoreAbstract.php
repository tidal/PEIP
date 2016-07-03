<?php

namespace PEIP\Data;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * InternalStoreAbstract 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage data 
 */



 
abstract class InternalStoreAbstract {

    private $internalValues = array();
    
    
    
    /**
     * @access protected
     * @param $key 
     * @return 
     */
    protected function hasInternalValue($key) {
        return array_key_exists($key, $this->internalValues);
    }   
    
    
    /**
     * @access protected
     * @param $key 
     * @return 
     */
    protected function getInternalValue($key) {
        return array_key_exists($key, $this->internalValues) ? $this->internalValues[$key] : NULL;
    }
    
    
    /**
     * @access protected
     * @param $key 
     * @return 
     */
    protected function deleteInternalValue($key) {
        unset($this->internalValues[$key]);
    }   

    
    /**
     * @access protected
     * @param $key 
     * @param $value 
     * @return 
     */
    protected function setInternalValue($key, $value) {
        $this->internalValues[$key] = $value;
    }
    
    
    /**
     * @access protected
     * @param $key 
     * @param $value 
     * @return 
     */
    
    /**
     * @access protected
     * @param $internalValues 
     * @return 
     */
    protected function setInternalValues(array $internalValues) {
        $this->internalValues = $internalValues;        
    }

    
    /**
     * @access protected
     * @param $key 
     * @return 
     */
    
    /**
     * @access protected
     * @return 
     */
    protected function getInternalValues() {
        return $this->internalValues;
    }

    
    /**
     * @access protected
     * @return 
     */
    protected function addInternalValues() {
        array_merge($this->internalValues, $internalValues);
    }   
    
}