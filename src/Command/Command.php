<?php

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Command 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage command 
 * @extends \PEIP\ABS\Command\Command
 * @implements \PEIP\INF\Command\Command, \PEIP\INF\Data\ParameterHolder
 */




namespace PEIP\Command;

class Command 
    extends \PEIP\ABS\Command\Command 
    implements \PEIP\INF\Command\Command {

    
    /**
     * @access public
     * @param $callable 
     * @param $params 
     * @return 
     */
    public function __construct($callable, array $params = array()){
        $this->callable = $callable;
        $this->setParameters($params);
    }
}