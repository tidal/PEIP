<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Generic_Builder 
 * Class to act as a factory for an abritrary class.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage base 
 * @implements PEIP_INF_Singleton_Map
 */


class PEIP_Generic_Builder 
    implements 
        PEIP_INF_Singleton_Map {

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
    public function __construct($className, ReflectionClass $reflectionClass = NULL, $storeRef = true){      
        if($reflectionClass ){
            
            if($reflectionClass->getName() != $className){
                throw new Exception(
                    'Constructing PEIP_Generic_Builder with wrong ReflectionClass'
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
     * Creates (if not exists) and returns PEIP_Generic_Builder instance for class. 
     * 
     * @access public
     * @param string $className class-name to return builder instance for 
     * @return PEIP_Generic_Builder builder instance for class
     */
    public static function getInstance($className){
        if(!array_key_exists((string)$className, self::$instances)) {
            new PEIP_Generic_Builder($className);
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
        if(PEIP_Test::assertClassHasConstructor($this->className)){
            if(!PEIP_Test::assertRequiredConstructorParameters($this->className, $arguments)){
                throw new Exception('Missing Argument '.(count($arguments) + 1).' for '.$this->className.'::__construct');
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
        return PEIP_Reflection_Pool::getInstance($this->className);
    }
    
}
