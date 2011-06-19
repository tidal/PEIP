<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_ABS_Transformer
 * Abstract base class for transformers. 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage transformer 
 * @extends PEIP_Pipe
 * @implements PEIP_INF_Transformer, PEIP_INF_Connectable, PEIP_INF_Subscribable_Channel, PEIP_INF_Channel, PEIP_INF_Handler, PEIP_INF_Message_Builder
 */


abstract class PEIP_ABS_Transformer 
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
     * Sends transformed message on output-channel
     * 
     * @access public
     * @param PEIP_INF_Message $message message to transform content 
     * @return 
     */
    public function doReply(PEIP_INF_Message $message){     
        $this->replyMessage($this->transform($message));
    }
  
    /**
     * Transforms a message 
     * 
     * @access public
     * @param PEIP_INF_Message $message 
     * @return mixed result of transforming the message 
     */
    public function transform(PEIP_INF_Message $message){
        return $this->doTransform($message);
    }


    /**
     * Transforms a message 
     * 
     * @abstract
     * @access protected
     * @param PEIP_INF_Message $message 
     * @return mixed result of transforming the message 
     */
    abstract protected function doTransform(PEIP_INF_Message $message);

}

