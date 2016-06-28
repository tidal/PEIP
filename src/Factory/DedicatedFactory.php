<?php

namespace PEIP\Factory;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * DedicatedFactory 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage factory 
 * @extends \PEIP\Data\ParameterHolder
 * @implements \PEIP\INF\Data\ParameterHolder, \PEIP\INF\Factory\DedicatedFactory
 */



use \PEIP\Data\ParameterHolder;
use PEIP\Base\GenericBuilder;

class DedicatedFactory 
    extends \PEIP\Data\ParameterHolder 
    implements \PEIP\INF\Factory\DedicatedFactory {

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
        return new DedicatedFactory(array($class, '__construct'), $parameters); 
    } 

    public static function getfromCallable($callable, array $parameters = array()){
        return new DedicatedFactory($callable, $parameters); 
    } 
    
    
    /**
     * @access public
     * @param $arguments 
     * @return 
     */
    public function build(array $arguments = array()){
        $arguments = count($arguments) > 0 ? $arguments : $this->getParameters();
        return (is_array($this->callable) && $this->callable[1] == '__construct') 
            ? GenericBuilder::GetInstance($this->callable[0])->build($arguments) 
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