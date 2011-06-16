<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Service_Container_Builder 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage service 
 * @extends PEIP_Internal_Store_Abstract
 */




class PEIP_Service_Container_Builder extends PEIP_Internal_Store_Abstract{
    
    
    
    /**
     * @access public
     * @param $key 
     * @param $factory 
     * @return 
     */
    public function setFactory($key, PEIP_Dedicated_Factory $factory){
            $this->setInternalValue($key, $factory);
    }

    
    /**
     * @access public
     * @param $key 
     * @return 
     */
    public function getFactory($key){
            $this->getInternalValue($key);
    }

    
    /**
     * @access public
     * @param $key 
     * @return 
     */
    public function hasFactory($key){
            $this->hasInternalValue($key);
    }

    
    /**
     * @access public
     * @param $key 
     * @return 
     */
    public function deleteFactory($key){
            $this->deleteInternalValue($key);
    }

    
    /**
     * @access public
     * @param $key 
     * @return 
     */
    public function getService($key){
        return isset($this->services[$key]) ? $this->services[$key] : $this->services[$key] = $this->getFactory($key)->build();
    }
    
    
    
    /**
     * @access public
     * @param $key 
     * @return 
     */
    public function buildService($key){
        return $this->getFactory($key)->build();
    }   
    
    
    
    
    
}