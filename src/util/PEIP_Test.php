<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PEIP_Test
 *
 * @author timo
 */
class PEIP_Test {


    public static function assertClassHasConstructor($className){
        return (boolean) PEIP_Reflection_Pool::getInstance($className)->getConstructor();
    }

    public static function assertRequiredConstructorParameters($className, $parameters){
            return (boolean)
                !self::assertClassHasConstructor($className) ||
                count($parameters) >= PEIP_Reflection_Pool::getInstance($className)
                    ->getConstructor()
                    ->getNumberOfRequiredParameters();
    }

    public static function assertInstanceOf($className, $object){
        return (boolean) PEIP_Reflection_Pool::getInstance($className)
            ->isInstance($object);
    }


    public static function assertImplements($className, $interfaceName){
        $res = false;
        try { //$className = new $className;
            class_exists($className);
            $res =  PEIP_Reflection_Pool::getInstance($className)
                ->implementsInterface($interfaceName);            
        }  catch (Exception $e){
            $res = false; 
        }
        return $res;;
    }

    public static function assertEvent($event){
        return self::assertImplements($event, 'PEIP_INF_Event');
    }

    public static function assertEventSubject($event){
        return self::assertImplements($event, 'PEIP_INF_Event')
            && $event->getSubject();
    }

    public static function assertEventObjectSubject($event){
        return self::assertEventSubject($event)
            && is_object($event->getSubject());
    }
    public static function assertArrayAccess($var){
        return (boolean) is_array($var) || $var instanceof  ArrayAccess;
    }

    public static function assertHandler($var){
        return (boolean) is_callable($var) || $var instanceof PEIP_INF_Handler;
    }

    public static function castType($var, $type){
        switch($type){
            case 'string':
                $var = (string)$var;
                break;
            case 'integer':
                $var = (integer)$var;
                break;
            case 'float':
                $var = (float)$var;
                break;
            case 'boolean':
                $var = (boolean)$var;
                break;
            case 'object':
                $var = (object)$var;
                break;
            case 'array':
                $var = (array)$var;
                break;
        }

        return $var;
    }

    public static function ensureArrayAccess($var){
        if(!PEIP_Test::assertArrayAccess($var)){
            throw new InvalidArgumentException(
                'Value is not an array nor an instance of ArrayAccess'
            );
        }
        return $var;
    }


    public static function ensureHandler($var){
        if(!PEIP_Test::assertHandler($var)){
            throw new InvalidArgumentException(
                'Value is not an callable nor an instance of PEIP_INF_Handler'
            );
        }
        return $var;
    }

    public static function ensureImplements($className, $interfaceName){
        if(!PEIP_Test::assertImplements($className, $interfaceName)){
            throw new InvalidArgumentException(
                'Class "'.$className.'" is not an instanceof "'.$interfaceName.'"'
            );
        }
        return $className;
    }

    public static function assertMethod($className, $methodname){
        return PEIP_Reflection_Pool::getInstance($className)->hasMethod($methodname);
    }

}

