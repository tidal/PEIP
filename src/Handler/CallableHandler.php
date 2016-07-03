<?php

namespace PEIP\Handler;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * CallableHandler 
 * Class to wrap a PHP callable in a handler
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage event 
 * @implements \PEIP\INF\Handler\Handler
 */


class CallableHandler 
    implements \PEIP\INF\Handler\Handler {

    protected $callable;
    
    /**
     * constructor
     * 
     * @access public
     * @param callable $callable the callable to wrap with the handler 
     * @return 
     */
    public function __construct($callable) {
        $this->callable = $callable;    
    }
        
    /**
     * Handles a subject by calling the wrapped callable with the subject as argument.
     * 
     * @implements \PEIP\INF\Handler\Handler
     * @access public
     * @param mixed $subject the subject to handle
     * @return mixed result of calling the registered callable with given subject
     */
    public function handle($subject) {
        return call_user_func($this->callable, $subject);
    }
    
    /**
     * Allows the handler instance to act as a lambda function.
     * Delegates to own 'handle' method.
     * 
     * @access public
     * @param mixed $subject the subject to handle
     * @return mixed result of calling the registered callable with given subject
     * @see CallableHandler::handle 
     */
    public function __invoke($subject) {
        return $this->handle($subject); 
    }
    
    /**
     * Returns the callable wrapped by the handler instance.
     * 
     * @access public
     * @return callable callable wrapped by the handler
     */
    public function getCallable() {
        return $this->callable;
    }
    
}