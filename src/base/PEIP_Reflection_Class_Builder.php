<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Reflection_Class_Builder 
 * Provides a fluid interface to create ReflectionClass instances
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage base 
 * @implements PEIP_INF_Singleton_Map
 */

class PEIP_Reflection_Class_Builder implements PEIP_INF_Singleton_Map {

    protected static $reflectionClasses = array();
       
    /**
     * Returns instance of ReflectionClass for given class
     * 
     * @access public
     * @param string $className name of the class to return ReflectionClass for 
     * @return ReflectionClass the ReflectionClass instance for given class
     */    
    protected static function getReflectionClass($className){
        return array_key_exists($className, self::$reflectionClasses) 
            ? self::$reflectionClasses[$className] 
            : (self::$reflectionClasses[$className] = new ReflectionClass($className)); 
    }   
    
    /**
     * Returns instance of ReflectionClass for given class.
     * Implements PEIP_INF_Singleton_Map
     * 
     * @implements PEIP_INF_Singleton_Map
     * @access public
     * @param string $className name of the class to return ReflectionClass for 
     * @return ReflectionClass the ReflectionClass instance for given class
     */     
    public static function getInstance($className){
        return self::getReflectionClass($className);
    }

}

