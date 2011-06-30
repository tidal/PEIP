<?php

namespace PEIP\Service;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * ConfigMapper
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage Service
 */

class ConfigMapper {

    protected
        $classMapping = array(),
        $attributeMapping = array(),
        $mapping = array();


    public function setMapping($key, array $mapping){
        $this->addMapping($key, $mapping);
    }

    protected function addMapping($key, array $mapping){
        if(isset($this->mapping[$key])){
            $mapping = \array_merge($this->mapping[$key], $mapping);
        }

        $this->mapping[$key] = $mapping;  
    }

    public function getMapping($key){
        return $this->mapping[$key];
    }

    public function setClassMapping($key, $class){
        $mapping = array('class'=>$class);
        $this->addMapping($key, $mapping);
    }

    public function getClassMapping($key){
        return isset($this->mapping[$key]) && isset($this->mapping[$key]['class'])
            ? $this->mapping[$key]['class']
            : NULL;
    }

    public function map($key, $config){
        if(isset($this->mapping[$key])){
            $mapping = $this->mapping[$key];
            $config = self::mapType($config, $mapping);
            $config = self::mapClass($config, $mapping);
            $config = self::mapConstructorArg($config, $mapping);
            $config = self::mapProperties($config, $mapping);
            $config = self::mapActions($config, $mapping);
            $config = self::mapListeners($config, $mapping);
        }

        return $config;
    }

    protected static function mapType(array $config, array $mapping){
        if(isset($mapping['type'])){
            $config['type'] = $mapping['type'];
        }

        return $config;
    }

    protected static function mapClass(array $config, array $mapping){
        if(isset($mapping['class'])){
            $config['class'] = $mapping['class'];
        }
        return $config;
    }

    protected static function mapConstructorArg(array $config, array $mapping){
        if(isset($mapping['constructor_arg'])){
            $args = array();
            foreach((array)$mapping['constructor_arg'] as $nr=>$arg){
                    $ref = false;
                    if(\strpos($arg, '$')===0){
                        $arg = str_replace('$', '', $arg);
                        $ref = true;
                    }else{
                        $attr = $arg;
                    }
                    if(isset($config[$arg])){
                        if($ref){
                            $value = array('type'=>'service', 'ref'=>$config[$arg]);
                        }else{
                            $value = $config[$arg];
                        }

                        $args[] = $value;
                    }
                
            }
            $mapping['constructor_arg'] = $args;
            $config = \array_merge($config, $mapping);
        }
        return $config;
    }

    protected static function mapActions(array $config, array $mapping){
        if(isset($mapping['action'])){
            foreach((array)$mapping['action'] as $nr=>$action){
                $args = array();
                foreach((array)$mapping['action'][$nr]['arg'] as $arg){
                    if(isset($config[$arg])){
                        $args[] = $config[$arg];
                    }
                }
                $mapping['action'][$nr]['arg'] = $args;
            }
            $config = \array_merge($config, $mapping);
        }
        return $config;
    }

    protected static function mapProperties(array $config, array $mapping){
        return self::mapIndexAttributes('property', 'value', $config, $mapping);
    }

    protected static function mapListeners(array $config, array $mapping){
        return self::mapIndexAttributes('listener', 'ref', $config, $mapping);
    }

    protected static function mapIndexAttributes($nodeName, $attributeName, array $config, array $mapping){
        if(isset($mapping[$nodeName])){
            foreach((array)$mapping[$nodeName] as $nr=>$listener){
                if(isset($mapping[$nodeName][$nr][$attributeName])){
                    $ref = $mapping[$nodeName][$nr][$attributeName];
                    if(isset($config[$ref])){
                        $mapping[$nodeName][$nr][$attributeName] = $config[$ref];
                    }
                }
            }
            $config = \array_merge($config, $mapping);
        }
        return $config;
    }
}

