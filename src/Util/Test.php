<?php

namespace PEIP\Util;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Test.
 *
 * @author timo
 */
class Test
{
    public static function assertClassHasConstructor($className)
    {
        return (bool) ReflectionPool::getInstance($className)->getConstructor();
    }

    public static function assertRequiredConstructorParameters($className, $parameters)
    {
        return (bool)
                !self::assertClassHasConstructor($className) ||
                count($parameters) >= ReflectionPool::getInstance($className)
                    ->getConstructor()
                    ->getNumberOfRequiredParameters();
    }

    public static function assertInstanceOf($className, $object)
    {
        return (bool) ReflectionPool::getInstance($className)
            ->isInstance($object);
    }

    public static function assertClassOrInterfaceExists($className)
    {
        return (bool) class_exists($className) || interface_exists($className);
    }

    public static function assertImplements($className, $interfaceName)
    {
        $className = is_object($className) ? get_class($className) : $className;
        $res = false; //throw new \Exception();
        try {
            class_exists($className);
            $res = ReflectionPool::getInstance($className)
                ->implementsInterface($interfaceName);
        } catch (\Exception $e) {
            $res = false;
        }

        return $res;
    }

    public static function assertMessage($message)
    {
        return self::assertImplements($message, '\PEIP\INF\Message\Message');
    }

    public static function assertEvent($event)
    {
        return self::assertImplements($event, '\PEIP\INF\Event\Event');
    }

    public static function assertEventSubject($event)
    {
        return self::assertImplements($event, '\PEIP\INF\Event\Event')
            && $event->getSubject();
    }

    public static function assertEventObjectSubject($event)
    {
        return self::assertEventSubject($event)
            && is_object($event->getSubject());
    }

    public static function assertArrayAccess($var)
    {
        return (bool) is_array($var) || $var instanceof \ArrayAccess;
    }

    public static function assertHandler($var)
    {
        return (bool) is_callable($var) || $var instanceof \PEIP\INF\Handler\Handler;
    }

    public static function castType($var, $type)
    {
        switch ($type) {
            case 'string':
                $var = (string) $var;
                break;
            case 'integer':
                $var = (int) $var;
                break;
            case 'float':
                $var = (float) $var;
                break;
            case 'boolean':
                $var = (bool) $var;
                break;
            case 'object':
                $var = (object) $var;
                break;
            case 'array':
                $var = (array) $var;
                break;
        }

        return $var;
    }

    public static function ensureArrayAccess($var)
    {
        if (!self::assertArrayAccess($var)) {
            throw new \InvalidArgumentException(
                'Value is not an array nor an instance of ArrayAccess'
            );
        }

        return $var;
    }

    public static function ensureHandler($var)
    {
        if (!self::assertHandler($var)) {
            throw new \InvalidArgumentException(
                'Value is not an callable nor an instance of \PEIP\INF\Handler\Handler'
            );
        }

        return $var;
    }

    public static function ensureImplements($className, $interfaceName)
    {
        if (!self::assertImplements($className, $interfaceName)) {
            throw new \InvalidArgumentException(
                'Class "'.$className.'" is not an instanceof "'.$interfaceName.'"'
            );
        }

        return $className;
    }

    public static function assertMethod($className, $methodname)
    {
        return ReflectionPool::getInstance($className)->hasMethod($methodname);
    }
}
