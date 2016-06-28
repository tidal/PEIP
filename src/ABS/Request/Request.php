<?php

namespace PEIP\ABS\Request;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP\ABS\Request\Request 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage request 
 * @extends \PEIP\Data\ParameterHolder
 * @implements \PEIP\INF\Data\ParameterHolder, \PEIP\INF\Command\Command, \PEIP\INF\Request\Request
 */


use \PEIP\Data\ParameterHolder;

abstract class Request 
    extends \PEIP\Data\ParameterHolder 
    implements 
        \PEIP\INF\Command\Command,
        \PEIP\INF\Request\Request {

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