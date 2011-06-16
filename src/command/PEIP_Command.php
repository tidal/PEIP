<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Command 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage command 
 * @extends PEIP_ABS_Command
 * @implements PEIP_INF_Command, PEIP_INF_Parameter_Holder
 */



class PEIP_Command 
    extends PEIP_ABS_Command 
    implements PEIP_INF_Command {

    
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