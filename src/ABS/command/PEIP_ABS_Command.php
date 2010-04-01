<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_ABS_Command 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage command 
 * @extends PEIP_Parameter_Holder
 * @implements PEIP_INF_Parameter_Holder, PEIP_INF_Command
 */


abstract class PEIP_ABS_Command 
    extends PEIP_Parameter_Holder 
    implements 
        PEIP_INF_Command, 
        PEIP_INF_Parameter_Holder {

    protected $params;

    protected $callable;
    
    
    
    /**
     * @access public
     * @return 
     */
    public function __invoke(){
        return $this->execute();
    }

    
    /**
     * @access public
     * @return 
     */
    public function execute(){
        return call_user_func_array($this->callable, $this->getParameters());
    }   
    
}