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
     * @access public
     * @param $callable 
     * @return 
     */
    public function __construct($callable){
        $this->callable = $callable;    
    }
        
    /**
     * @access public
     * @param $subject 
     * @return 
     */
    public function handle($subject){
        return call_user_func($this->callable, $subject);
    }
    
    /**
     * @access public
     * @param $subject 
     * @return 
     */
    public function __invoke($subject){
        return $this->handle($subject); 
    }
    
    /**
     * @access public
     * @return 
     */
    public function getCallable(){
        return $this->callable;
    }
    
}