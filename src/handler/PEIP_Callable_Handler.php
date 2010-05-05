<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Callable_Handler 
 * Class to wrap a PHP callable in a handler
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage event 
 * @implements PEIP_INF_Handler
 */

class PEIP_Callable_Handler 
	implements PEIP_INF_Handler {

    protected $callable;
    
    /**
     * constructor
     * 
     * @access public
     * @param callable $callable the callable to wrap with the handler 
     * @return 
     */
    public function __construct($callable){
        $this->callable = $callable;    
    }
        
    /**
     * Handles a subject by calling the wrapped callable with the subject as argument.
     * 
     * @implements PEIP_INF_Handler
     * @access public
     * @param mixed $subject the subject to handle
     * @return mixed result of calling the registered callable with given subject
     */
    public function handle($subject){
        return call_user_func($this->callable, $subject);
    }
    
    /**
     * Allows the handler instance to act as a lambda function.
     * Delegates to own 'handle' method.
     * 
     * @access public
     * @param mixed $subject the subject to handle
     * @return mixed result of calling the registered callable with given subject
     * @see PEIP_Callable_Handler::handle 
     */
    public function __invoke($subject){
        return $this->handle($subject); 
    }
    
    /**
     * Returns the callable wrapped by the handler instance.
     * 
     * @access public
     * @return callable callable wrapped by the handler
     */
    public function getCallable(){
        return $this->callable;
    }
    
}