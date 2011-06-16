<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Error_Message 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage message 
 * @extends PEIP_Generic_Message
 * @implements PEIP_INF_Buildable, PEIP_INF_Message, PEIP_INF_Container
 */



class PEIP_Error_Message extends PEIP_Generic_Message implements PEIP_INF_Message {

    protected $payload;
    
    protected $headers; 
        
    
    /**
     * @access public
     * @param $payload 
     * @param $headers 
     * @return 
     */
    public function __construct(Exception $payload, array $headers = array()){
        $this->payload = $payload;
        $this->headers = $headers;
    }
    




}