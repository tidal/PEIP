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
 * ReflectionClassBuilder 
 * Provides a fluid interface to create ReflectionClass instances
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage base 
 * @implements \PEIP\INF\Base\SingletonMap
 */


class ReflectionClassBuilder implements \PEIP\INF\Base\SingletonMap {

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
            : (self::$reflectionClasses[$className] = new \ReflectionClass($className)); 
    }   
    
    /**
     * Returns instance of ReflectionClass for given class.
     * Implements \PEIP\INF\Base\SingletonMap
     * 
     * @implements \PEIP\INF\Base\SingletonMap
     * @access public
     * @param string $className name of the class to return ReflectionClass for 
     * @return ReflectionClass the ReflectionClass instance for given class
     */     
    public static function getInstance($className){
        return self::getReflectionClass($className);
    }

}

