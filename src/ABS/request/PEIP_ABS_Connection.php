<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_ABS_Connection 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage request 
 * @implements PEIP_INF_Connection
 */




abstract class PEIP_ABS_Connection 
    implements PEIP_INF_Connection {


    
    
    /**
     * @access public
     * @param $request 
     * @return 
     */
    public function sendRequest(PEIP_ABS_Request $request){
        return $this->doSendRequest($request);
    }
    
    
    /**
     * @access protected
     * @param $request 
     * @return 
     */
    abstract protected function doSendRequest(PEIP_ABS_Request $request);
    

}