<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Wiretap 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage listener 
 * @extends PEIP_Fixed_Event_Pipe
 * @implements PEIP_INF_Message_Builder, PEIP_INF_Handler, PEIP_INF_Channel, PEIP_INF_Subscribable_Channel, PEIP_INF_Connectable, PEIP_INF_Listener
 */


class PEIP_Wiretap 
    extends PEIP_Fixed_Event_Pipe {

    
    /**
     * @access public
     * @param $inputChannel 
     * @param $outputChannel 
     * @return 
     */
    public function __construct(PEIP_INF_Channel $inputChannel, PEIP_INF_Channel $outputChannel = NULL){
        $this->setEventName('preSend');
        $this->setInputChannel($inputChannel);
        if(is_object($outputChannel)){
            $this->setOutputChannel($outputChannel);
        }           
    }           
        
    
    /**
     * @access protected
     * @param $message 
     * @return 
     */
    protected function doReply(PEIP_INF_Message $message){
        $this->replyMessage($message->getHeader('MESSAGE'));
    }
    
} 
