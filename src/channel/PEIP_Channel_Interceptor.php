<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Channel_Interceptor 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 * @implements PEIP_INF_Message_Channel_Interceptor
 */


class PEIP_Channel_Interceptor 
	implements PEIP_INF_Channel_Interceptor {
  
    /**
     * @access public
     * @param $message 
     * @param $channel 
     * @param $sent 
     * @return 
     */
    public function postSend(PEIP_INF_Message $message, PEIP_INF_Channel $channel, $sent){
    
    }
    
    
    /**
     * @access public
     * @param $message 
     * @param $channel 
     * @return 
     */
    public function preSend(PEIP_INF_Message $message, PEIP_INF_Channel $channel){
    
    }
    
}