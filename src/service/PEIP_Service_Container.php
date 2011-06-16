<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Service_Container 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage service 
 * @extends PEIP_Parameter_Holder
 * @implements PEIP_INF_Parameter_Holder, PEIP_INF_Service_Container
 */


class PEIP_Service_Container
    extends PEIP_ABS_Connectable
    implements 
        PEIP_INF_Service_Container{

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