<?php

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP\ABS\Command\Command 
 * Basic abstract implementation of comman pattern.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage command 
 * @extends \PEIP\Data\ParameterHolder
 * @implements \PEIP\INF\Data\ParameterHolder, \PEIP\INF\Command\Command
 */


use \PEIP\Data\ParameterHolder;

namespace PEIP\ABS\Command;

abstract class Command 
    extends \PEIP\Data\ParameterHolder 
    implements 
        \PEIP\INF\Command\Command, 
        \PEIP\INF\Data\ParameterHolder {

    protected 
        $params,
        $callable;
       
    /**
     * Allows a instance of the class to act as a lambda function.
     * 
     * @access public
     * @return 
     */
    public function __invoke(){
        return $this->execute();
    }
   
    /**
     * Executes/calls the registered callable with registered 
     * parameters as arguments
     * 
     * @access public
     * @return 
     */
    public function execute(){
        return call_user_func_array($this->callable, $this->getParameters());
    }   
        
}