<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PEIP_Reflection_Pool
 *
 * @author timo
 */
class PEIP_Reflection_Pool {

    protected static $instances = array();


    /**
	 * Constructs a ReflectionClass
	 * @param $argument
     * @return ReflectionClass
	 */
    public  static function getInstance($argument){

        $className = is_object($argument)
            ? get_class($argument)
            : (string) $argument;
        return isset(self::$instances[$className])
            ? self::$instances[$className]
            : self::$instances[$className] = new ReflectionClass($className);

    }




}

