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
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage base 
 * @implements PEIP_INF_Singleton_Map
 */


class PEIP_Reflection_Class_Builder implements PEIP_INF_Singleton_Map {

    protected static $reflectionClasses = array();
    
    protected static function getReflectionClass($className){
        return array_key_exists($className, self::$reflectionClasses) 
            ? self::$reflectionClasses[$className] 
            : (self::$reflectionClasses[$className] = new ReflectionClass($className)); 
    }   
    
    
    public static function getInstance($className){
        return self::getReflectionClass($className);
    }

}

