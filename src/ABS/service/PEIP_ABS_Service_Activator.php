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
     * @access public
     * @param $message 
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