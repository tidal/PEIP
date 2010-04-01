<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Direct_Channel 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 * @extends PEIP_ABS_Subscribable_Channel
 * @implements PEIP_INF_Subscribable_Channel, PEIP_INF_Channel, PEIP_INF_Interceptable, PEIP_INF_Connectable
 */



class PEIP_Direct_Channel 
    extends PEIP_ABS_Subscribable_Channel {

    
    /**
     * @access public
     * @param $message 
     * @param $timeout 
     * @return 
     */
    public function send(PEIP_INF_Message $message, $timeout = -1){
        $this->dispatchInterceptor($message, 'preSend');
        $sent = $this->doSend($message);
        $this->dispatchInterceptor($message, 'postSend', array('sent' => $sent));
    }       
        
        
    
    /**
     * @access protected
     * @param $message 
     * @return 
     */
    protected function doSend(PEIP_INF_Message $message){
        $this->getMessageDispatcher()->notify($message);
        return true;
    }
        
    
    /**
     * @access public
     * @return 
     */
    public function getMessageDispatcher(){
        return isset($this->dispatcher) ? $this->dispatcher : $this->dispatcher = new PEIP_Iterating_Dispatcher;
    }   
    
} 