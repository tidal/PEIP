<?php

namespace PEIP\Service;

namespace PEIP\Service;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * ServiceContainer 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage service 
 * @extends PEIP\Data\ParameterHolder
 * @implements \PEIP\INF\Data\ParameterHolder, \PEIP\INF\Service\ServiceContainer
 */



class ServiceContainer
    extends \PEIP\ABS\Base\Connectable
    implements 
        \PEIP\INF\Service\ServiceContainer{

    protected $services = array();
    
    
  /**
   * Constructor.
   *
   * @param array $parameters An array of parameters
   */
    
    
    /**
     * @access public
     * @param $key 
     * @param $service 
     * @return 
     */
    public function setService($key, $service){
        $this->services[$key] = $service;
    }
    
    
    /**
     * @access public
     * @param $key 
     * @return 
     */
    public function getService($key){
        return $this->services[$key];
    }
    
    
    /**
     * @access public
     * @param $key 
     * @return 
     */
    public function hasService($key){
        return array_key_exists($key, $this->services); 
    }   

    
    /**
     * @access public
     * @param $key 
     * @return 
     */
    public function deleteService($key){
        unset($this->services[$key]);
    }
    
}