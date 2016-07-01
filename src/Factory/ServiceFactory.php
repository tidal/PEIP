<?php

namespace PEIP\Factory;
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ServiceFactory
 *
 * @author timo
 */
use PEIP\Util\Test;
use PEIP\Base\GenericBuilder;
use PEIP\Context\XMLContext;

class ServiceFactory {
     /**
     * Creates and initializes service instance from a given configuration.
     *
     * @access public
     * @param $config configuration of the service
     * @return object the initialized service instance
     */
    public static function createService(array $config){
        $args = array();
        //build arguments for constructor
        if(isset($config['constructor_arg'])){
            foreach($config['constructor_arg'] as $arg){
                $args[] = self::buildArg($arg);
            }
        }
        return self::buildAndModify($config, $args);
    }

        /**
     * Builds an arbitrary service/object instance from a config-obect.
     *
     * @static
     * @access protected
     * @param object $config configuration object to build a service instance from.
     * @param array $arguments arguments for the service constructor
     * @param string $defaultClass class to create instance for if none is set in config
     * @return object build and modified srvice instance
     */
    public static function doBuild($config, $arguments, $defaultClass = false){
        $cls = isset($config["class"]) ? trim((string)$config["class"]) : (string)$defaultClass;
        if($cls != ''){
            try {
                $constructor = isset($config["constructor"])?(string)$config["constructor"]:"";
                if($constructor != '' && Test::assertMethod($cls, $constructor)){
                    $service = call_user_func_array(array($cls, $constructor), $arguments);
                }else{
                    $service = self::build($cls, $arguments);
                }
            }catch(\Exception $e){
                throw new \RuntimeException('Could not create Service "'.$cls.'" -> '.$e->getMessage());
            }
        }
        if(is_object($service)){
            return $service;
        }
        throw new \RuntimeException('Could not create Service "'.$cls.'". Class does not exist.');
    }


    /**
     * Utility function to build an object instance for given class with given constructor-arguments.
     *
     * @see GenericBuilder
     * @static
     * @access protected
     * @param object $className name of class to build instance for.
     * @param array $arguments arguments for the constructor
     * @return object build and modified srvice instance
     */
    public static function build($className, $arguments){
        return GenericBuilder::getInstance($className)->build($arguments);
    }

        /**
     * Builds single argument (to call a method with later) from a config-obect.
     *
     * @access protected
     * @param object $config configuration object to create argument from.
     * @return mixed build argument
     */
    protected function buildArg($config){
        if(trim((string)$config['value']) != ''){
            $arg = (string)$config['value'];
        }elseif($config->getName() == 'value'){
            $arg = (string)$config;
        }elseif($config->getName() == 'list'){
            $arg = array();
            foreach($config->children() as $entry){
                if($entry->getName() == 'value'){
                    if($entry['key']){
                        $arg[(string)$entry['key']] = (string)$entry;
                    }else{
                        $arg[] = (string)$entry;
                    }
                }elseif($entry->getName() == 'service'){
                    $arg[] = $this->provideService($entry);
                }
            }
        }elseif($config->getName() == 'service'){
            $arg = self::provideService($config);
        }elseif($config->list){
            $arg = $this->buildArg($config->list);
        }elseif($config->service){
            $arg = $this->buildArg($config->service);
        }
        return $arg;
    }

    /**
     * Builds and modifies an arbitrary service/object instance from a config-obect.
     *
     * @see XMLContext::doBuild
     * @see PEIP\Factory\ServiceFactory::modifyService
     * @implements \PEIP\INF\Context\Context
     * @access public
     * @param object $config configuration array to build a service instance from.
     * @param array $arguments arguments for the service constructor
     * @param string $defaultClass class to create instance for if none is set in config
     * @return object build and modified srvice instance
     */
    public static function buildAndModify(array $config, $arguments, $defaultClass = ""){
        if((isset($config["class"]) && "" != (string)$config["class"])  || $defaultClass !== ""){
             $service = ServiceFactory::doBuild($config, $arguments, $defaultClass);
        }else{
            throw new \RuntimeException('Could not create Service. no class or reference given.');
        }
        if(isset($config["ref_property"])){
            $service = $service->{(string)$config["ref_property"]};
        }elseif(isset($config["ref_method"])){
                $args = array();
            if(isset($config['argument'])){
                        foreach($config['argument'] as $arg){
                            $args[] = $this->buildArg($arg);
                        }
                }
            $service = call_user_func_array(array($service, (string)$config["ref_method"]), $args);
        }
        if(!is_object($service)){
            throw new \RuntimeException('Could not create Service.');
        }
        $service = self::modifyService($service, $config);
        
        return $service;
    }


    /**
     * Modifies a service instance from configuration.
     *  - Sets properties on the instance.
     *  -- Calls a public setter method if exists.
     *  -- Else sets a public property if exists.
     *  - Calls methods on the instance.
     *  - Registers listeners to events on the instance
     *
     * @access protected
     * @param object $service the service instance to modify
     * @param object $config configuration to get the modification instructions from.
     * @return object the modificated service
     */
    protected function modifyService($service, $config){        
        $config = is_array($config) ? new \ArrayObject($config) : $config;
        // set instance properties
        if(isset($config->property)){
            foreach($config->property as $property){
                $arg = $this->buildArg($property);
                if($arg){
                    $setter = self::getSetter($property);
                    if($setter &&  self::hasPublicProperty($service, 'Method', $setter)){
                        $service->{$setter}($arg);
                    }elseif(in_array($property, self::hasPublicProperty($service, 'Property', $setter))){
                        $service->$setter = $arg;
                    }
                }
            }
        }
        // call instance methods
        if(isset($config->action)){
            foreach($config->action as $action){
                $method = (string)$action['method'] != '' ? (string)$action['method'] : NULL;
                if($method && self::hasPublicProperty($service, 'Method', $method)){
                    $args = array();
                    foreach($action->children() as $argument){
                        $args[] = $this->buildArg($argument);
                    }
                    call_user_func_array(array($service, (string)$action['method']), $args);
                }
            }
        }
        // register instance listeners
        if($service instanceof \PEIP\INF\Event\Connectable){
            if(isset($config->listener)){
                foreach($config->listener as $listenerConf){
                    $event = (string)$listenerConf['event'];
                    $listener = $this->provideService($listenerConf);
                    $service->connect($event, $listener);
                }
            }
        }
        return $service;
    } 
}

