<?php

namespace PEIP\Message;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * CallableMessageHandler 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage message 
 * @implements \PEIP\INF\Handler\Handler
 */




class CallableMessageHandler 
    implements \PEIP\INF\Handler\Handler {

    protected 
        $callable,
        $requiredParameters;
    
    
    /**
     * @access public
     * @param $callable 
     * @return 
     */
    public function __construct($callable){
        $this->callable = $callable;    
        $this->examineCallabe();
    }

    
    /**
     * @access protected
     * @return 
     */
    protected function examineCallabe(){
        if(is_callable($this->callable)){        
            if(is_array($this->callable)){
                list($class, $method) =  $this->callable;
                $static = !is_object($class);
                $class = is_object($class) ? get_class($class) : (string)$class;
                $reflectionClass = new \ReflectionClass($class);
                $reflectionFunc = $reflectionClass->getMethod($method);
                if($static && !$reflectionFunc->isStatic()){
                    throw new \InvalidArgumentException('Argument 1 passed to CallableMessageHandler::__construct is not an Callable: Method "'.$method.'" of class '.$class.' is not static.');                  
                }
            }else{
                $reflectionFunc = new \ReflectionFunction($this->callable);  
            }
            $this->requiredParameters = $reflectionFunc->getNumberOfRequiredParameters();
        }else{
            throw new \InvalidArgumentException('Argument 1 passed to CallableMessageHandler::__construct is not a Callable');
        }   
    }   
    
    
    /**
     * @access public
     * @param $message 
     * @param $channel 
     * @param $sent 
     * @return 
     */
    public function handle($message, $channel = false, $sent = false){
        if(!is_object($message)){
            throw new \InvalidArgumentException('Argument 1 passed to CallableMessageHandler::handle is not a Object');       
        }   
        try {
            return call_user_func_array($this->callable, array($message, $channel, $sent));
        }
        catch(\Exception $e){
            throw new \RuntimeException('Unable to call Callable: '.$e->getMessage());
        }   
    }   
}