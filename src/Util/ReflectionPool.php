<?php

namespace PEIP\Util;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReflectionPool.
 *
 * @author timo
 */
class ReflectionPool
{
    protected static $instances = [];

    /**
     * Constructs a ReflectionClass.
     *
     * @param $argument
     *
     * @return ReflectionClass
     */
    public static function getInstance($argument)
    {
        $className = is_object($argument)
            ? get_class($argument)
            : (string) $argument;

        return isset(self::$instances[$className])
            ? self::$instances[$className]
            : self::$instances[$className] = new \ReflectionClass($className);
    }
}
