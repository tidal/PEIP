<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_ABS_Request 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage request 
 * @extends PEIP_Parameter_Holder
 * @implements PEIP_INF_Parameter_Holder, PEIP_INF_Command, PEIP_INF_Request
 */


abstract class PEIP_ABS_Request 
    extends PEIP_Parameter_Holder 
    implements 
        PEIP_INF_Command,
        PEIP_INF_Request {

    protected $connection;
    
    
    /**
     * @access public
     * @param $connection 
     * @return 
     */
    public function setConnection($connection){
        $this->connection = $connection;
    }
    
    
    
    /**
     * @access public
     * @return 
     */
    public function execute(){
        return $this->send();   
    }

    
    /**
     * @access public
     * @return 
     */
    public function send(){
        return $this->connection->sendRequest($this);
    }
    
    
    /**
     * @access public
     * @return 
     */
    public function getRequestData(){
        return $this->doGetRequestData();   
    }
    
    
    /**
     * @access protected
     * @return 
     */
    abstract protected function doGetRequestData();
    
    
}