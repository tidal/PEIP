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
        $className,
        $reflectionClass;
    
    protected static 
        $instances = array();   
    
    
    /**
     * @access public
     * @param $className 
     * @param $reflectionClass 
     * @param $storeRef 
     * @return 
     */
    public function __construct($className, ReflectionClass $reflectionClass = NULL, $storeRef = true){      
        $this->className = $className;
        if($reflectionClass){
            if($className != $reflectionClass->getName()){
                throw new Exception('Constructing PEIP_Generic_Builder with wrong ReflectionClass'); 
            }   
            $this->reflectionClass = $reflectionClass;  
        }
        if($storeRef){
            self::$instances[$className] = $this;
        }            
    }
    
    public static function getInstance($className){
        if(!array_key_exists((string)$className, self::$instances)) {
            new PEIP_Generic_Builder($className);
        }
        return self::$instances[$className];
    }

    
    /**
     * @access public
     * @param $arguments 
     * @return 
     */
    public function build(array $arguments = array()){      
        if($constructor = $this->getReflectionClass()->getConstructor()){
            if(count($arguments) < $constructor->getNumberOfRequiredParameters()){ 
                throw new Exception('Missing Argument '.(count($arguments) + 1).' for '.$className.'::__construct');
            }       
            return $this->getReflectionClass()->newInstanceArgs($arguments);
        }else{
            return $this->getReflectionClass()->newInstance();
        }               
    }

    
    /**
     * @access public
     * @return 
     */
    public function getReflectionClass(){
        return $this->reflectionClass 
            ? $this->reflectionClass 
            : $this->reflectionClass = new ReflectionClass($this->className); 
    }
    
}
