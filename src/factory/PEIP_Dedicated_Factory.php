<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Dedicated_Factory 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage factory 
 * @extends PEIP_Parameter_Holder
 * @implements PEIP_INF_Parameter_Holder, PEIP_INF_Dedicated_Factory
 */



class PEIP_Dedicated_Factory 
    extends PEIP_Parameter_Holder 
    implements PEIP_INF_Dedicated_Factory {

    protected $callable;        
    
    
    /**
     * @access protected
     * @param $callable 
     * @param $parameters 
     * @return 
     */
    protected function __construct($callable ,array $parameters = array()){
        $this->callable = $callable;
        $this->setParameters($parameters);
    }

    public static function getfromClass($class, array $parameters = array()){
        return new PEIP_Dedicated_Factory(array($class, '__construct'), $parameters); 
    } 

    public static function getfromCallable($callable, array $parameters = array()){
        return new PEIP_Dedicated_Factory($callable, $parameters); 
    } 
    
    
    /**
     * @access public
     * @param $arguments 
     * @return 
     */
    public function build(array $arguments = array()){
        $arguments = count($arguments) > 0 ? $arguments : $this->getParameters();
        return (is_array($this->callable) && $this->callable[1] == '__construct') 
            ? PEIP_Generic_Builder::GetInstance($this->callable[0])->build($arguments) 
            : call_user_func_array($this->callable, $arguments);
    }

    
    /**
     * @access public
     * @param $method 
     * @return 
     */
    public function setConstructor($method){
        $this->constructor = (string)$method;
        return $this;
    }   
    
}