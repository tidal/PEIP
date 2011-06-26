<?php

namespace PEIP\Util;
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Reflection
 *
 * @author timo
 */

class Reflection {

    protected static $classInfo = array();

    /*
     * returns implemeted interfaces and (parents) class names as array.
     * When second parameter ($store) ist set to FALSE, the class-info will
     * not be cached. This serves some memory (e.g. 500b per requested class),
     * but wil make subsequent calls slower (about 4-5 times). So when you use
     * this method only once per process, set $store to FALSE - otherwise set
     * $store to TRUE. Since PEIP is created for performance on heavy usage
     * the default for store is TRUE.
     *
     * @param  string name/instance of the class to return info for
     * @param  boolean wether to store the info for the class internally
     * @return array array with interface/class info for the class
     */

    public static function getImplementedClassesAndInterfaces($class, $store = true){
        $class = is_object($class) ? get_class($class) : (string)$class;
        if(isset(self::$classInfo[$class])){
            return self::$classInfo[$class];
        }
        $cls = ReflectionPool::getInstance($class);
        // get the names of implemented interfaces
        $classInfo = (array)$cls->getInterfaceNames();
        $classInfo[] = $cls->getName();
        // get names of parent-classes
        while($cls = $cls->getParentClass()){
            $classInfo[] = $cls->getName();
        }
        
        return $store 
            ? self::$classInfo[$class] = $classInfo
            : $classInfo;
    }



}

