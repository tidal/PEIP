<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_ABS_Message_Splitter
 * Abstract base class for message-splitters. 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage splitter 
 * @extends PEIP_Pipe
 * @implements PEIP_INF_Connectable, PEIP_INF_Subscribable_Channel, PEIP_INF_Channel, PEIP_INF_Handler, PEIP_INF_Message_Builder
 */


abstract class PEIP_ABS_Message_Splitter 
    extends PEIP_Pipe {
   
    /**
     * constructor
     * 
     * @access public
     * @param PEIP_INF_Channel $inputChannel the input-channel
     * @param PEIP_INF_Channel $outputChannel the outputs-channel 
     * @return 
     */
    public function __construct(PEIP_INF_Channel $inputChannel, PEIP_INF_Channel $outputChannel = NULL){
        $this->setInputChannel($inputChannel);
        if(is_object($outputChannel)){
            $this->setOutputChannel($outputChannel);    
        }   
    }           
         
    /**
     * Sends splitted message on output-channel
     * 
     * @access public
     * @param PEIP_INF_Message $message message to split 
     * @return 
     */
    public function doReply(PEIP_INF_Message $message){     
        $res = $this->split($message);      
        if(is_array($res)){
            foreach($res as $msg){ 
                $this->replyMessage($msg);
            }
        }else{
            $this->replyMessage($res);
        }
    }
  
    /**
     * Splits a message 
     * 
     * @abstract
     * @access public
     * @param PEIP_INF_Message $message 
     * @return mixed result of splitting the message - array or arbitrary value
     */
    abstract public function split(PEIP_INF_Message $message);

}

