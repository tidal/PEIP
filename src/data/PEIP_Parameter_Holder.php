<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Parameter_Holder 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage data 
 * @implements PEIP_INF_Parameter_Holder
 */



class PEIP_Parameter_Holder 
    implements PEIP_INF_Parameter_Holder {

    protected $parameters = array();
    
    
    
    /**
     * @access public
     * @param $key 
     * @return 
     */
    public function hasParameter($key){
        return array_key_exists($key, $this->parameters);
    }   
    
    
    /**
     * @access public
     * @param $key 
     * @return 
     */
    public function getParameter($key){
        return array_key_exists($key, $this->parameters) ? $this->parameters[$key] : NULL;
    }
    
    
    /**
     * @access public
     * @param $key 
     * @return 
     */
    public function deleteParameter($key){
        unset($this->parameters[$key]);
    }   

    
    /**
     * @access public
     * @param $key 
     * @param $value 
     * @return 
     */
    public function setParameter($key, $value){
        $this->parameters[$key] = $value;
    }
    
    
    /**
     * @access public
     * @param $key 
     * @param $value 
     * @return 
     */
    
    /**
     * @access public
     * @param $parameters 
     * @return 
     */
    public function setParameters(array $parameters){
        $this->parameters = $parameters;        
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
    public function getParameters(){
        return $this->parameters;
    }

    
    /**
     * @access public
     * @param $parameters 
     * @return 
     */
    public function addParameters(array $parameters){
        $this->parameters = array_merge($this->parameters, $parameters);
        array_unique($this->parameters);
    }   


    
    /**
     * @access public
     * @param $parameters 
     * @return 
     */
    
    /**
     * @access public
     * @param $parameters 
     * @return 
     */
    public function addParametersIfNot(array $parameters){
        $this->parameters = array_merge($parameters, $this->parameters);
        array_unique($this->parameters);
    }   

}