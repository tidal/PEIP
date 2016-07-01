<?php

namespace PEIP\Base;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * GenericBuilder 
 * Class to act as a factory for an abritrary class.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage base 
 * @implements \PEIP\INF\Base\SingletonMap
 */


use PEIP\Util\Test;
use PEIP\Util\ReflectionPool;

class GenericBuilder 
    implements 
        \PEIP\INF\Base\SingletonMap {

    protected 
        $className;
    
    protected static 
        $instances = array();   
     
    /**
     * constructor
     * 
     * @access public
     * @param string $className class-name to create objects for
     * @param ReflectionClass $reflectionClass reflection-class for class. default: NULL 
     * @param boolean $storeRef wether to store a reference for new instance. default: true 
     * @return 
     */
    public function __construct($className, \ReflectionClass $reflectionClass = NULL, $storeRef = true){
        if($reflectionClass ){
            
            if($reflectionClass->getName() != $className){
                throw new \Exception(
                    'Constructing GenericBuilder with wrong ReflectionClass'
                );
            }
             
             
            $this->reflectionClass = $reflectionClass;
        }
        $this->className = $className;
        if($storeRef){
            self::$instances[$this->className] = $this;
        }            
    }

    /**
     * Creates (if not exists) and returns GenericBuilder instance for class. 
     * 
     * @access public
     * @param string $className class-name to return builder instance for 
     * @return GenericBuilder builder instance for class
     */
    public static function getInstance($className){
        if(!array_key_exists((string)$className, self::$instances)) {
            new GenericBuilder($className);
        }
        return self::$instances[$className];
    }
  
    /**
     * Creates object instance with given arguments. 
     * 
     * @access public
     * @param array $arguments array of constructore arguments
     * @return object the created object instance
     */
    public function build(array $arguments = array()){      
        if(Test::assertClassHasConstructor($this->className)){
            if(!Test::assertRequiredConstructorParameters($this->className, $arguments)){
                throw new \Exception('Missing Argument '.(count($arguments) + 1).' for '.$this->className.'::__construct');
            }
            return $this->getReflectionClass()->newInstanceArgs($arguments);
        }
        return $this->getReflectionClass()->newInstance();              
    }
   
    /**
     * returns reflection class instance
     * 
     * @access public
     * @return ReflectionClass
     */
    public function getReflectionClass(){
        return ReflectionPool::getInstance($this->className);
    }
    
}
