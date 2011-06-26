<?php

namespace PEIP\Service;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * ServiceContainerBuilder 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage service 
 * @extends \PEIP\Data\InternalStoreAbstract
 */




use \PEIP\Data\InternalStoreAbstract;
use PEIP\Factory\DedicatedFactory;

class ServiceContainerBuilder extends \PEIP\Data\InternalStoreAbstract{
    
    
    
    /**
     * @access public
     * @param $key 
     * @param $factory 
     * @return 
     */
    public function setFactory($key, DedicatedFactory $factory){
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