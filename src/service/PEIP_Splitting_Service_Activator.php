<?php
/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Service_Activator 
 * 
 * Calls the service method with the content of the Message as arguments
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage service 
 * @extends PEIP_ABS_Service_Activator
 * @implements PEIP_INF_Message_Builder, PEIP_INF_Handler, PEIP_INF_Channel, PEIP_INF_Subscribable_Channel, PEIP_INF_Connectable
 */


class PEIP_Splitting_Service_Activator
    extends PEIP_Service_Activator {
            
    
    /**
     * @access public
     * @param $message 
     * @return 
     */
    public function doReply(PEIP_INF_Message $message){
        if(is_callable($this->serviceCallable)){
            $res = call_user_func_array($this->serviceCallable, $message->getContent());
        }elseif(is_object($this->serviceCallable) && method_exists($this->serviceCallable, 'handle')){
            $res = call_user_func_array(array($this->serviceCallable, 'handle'), $message->getContent());            	
        }
        $out = (bool)$message->hasHeader('REPLY_CHANNEL') 
        	? $message->getHeader('REPLY_CHANNEL') 
        	: $this->outputChannel;    
        if($out){
            $this->replyMessage($res, $res);    
        }
    } 
    	
    
}
