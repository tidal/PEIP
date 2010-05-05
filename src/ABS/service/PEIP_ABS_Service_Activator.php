<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_ABS_Service_Activator 
 * Abstract base class for all service activators
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage service 
 * @extends PEIP_Pipe
 * @implements PEIP_INF_Connectable, PEIP_INF_Subscribable_Channel, PEIP_INF_Channel, PEIP_INF_Handler, PEIP_INF_Message_Builder
 */

abstract class PEIP_ABS_Service_Activator
    extends PEIP_Pipe {
        
    protected 
        $serviceCallable;
         
    /**
     * Handles the reply logic.
     * Delegates calling of service to method 'callService'.
     * Replies on message´s reply-channel or registered output-channel if set.
     * 
     * @access protected
     * @param PEIP_INF_Message $message message to handle/reply for
     * @return 
     */
    public function doReply(PEIP_INF_Message $message){
        $res = $this->callService($message);
        $out = (bool)$message->hasHeader('REPLY_CHANNEL') 
        	? $message->getHeader('REPLY_CHANNEL') 
        	: $this->outputChannel;    
        if($out){
            $this->replyMessage($res, $res);    
        }
    }  

    /**
     * Calls a method on a service (registered as a callable) with 
     * content/payload of given message as argument.
     * 
     * @access protected
     * @param PEIP_INF_Message $message message to call the service with it´s content/payload
     * @return mixed result of calling the registered service callable with message content/payload
     */
    protected function callService(PEIP_INF_Message $message){
		$res = NULL;
    	if(is_callable($this->serviceCallable)){
            $res = call_user_func($this->serviceCallable, $message->getContent());
        }else{
            if(is_object($this->serviceCallable) && method_exists($this->serviceCallable, 'handle')){
                $res = $this->serviceCallable->handle($message->getContent());
            }
        }    
    	return $res;
    }   
} 