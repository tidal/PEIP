<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_ABS_Reply_Producing_Message_Handler 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage handler 
 * @extends PEIP_ABS_Message_Handler
 * @implements PEIP_INF_Handler, PEIP_INF_Message_Builder
 */


abstract class PEIP_ABS_Reply_Producing_Message_Handler
    extends PEIP_ABS_Message_Handler
    implements PEIP_INF_Message_Builder {
    
    protected 
        $outputChannel,
        $messageClass = 'PEIP_Generic_Message';

    
    /**
     * @access public
     * @param $outputChannel 
     * @return 
     */
    public function setOutputChannel(PEIP_INF_Channel $outputChannel){
        $this->doSetOutputChannel($outputChannel);
        return $this;
    }   

    
    /**
     * @access protected
     * @param $outputChannel 
     * @return 
     */
    protected function doSetOutputChannel(PEIP_INF_Channel $outputChannel){
        $this->outputChannel = $outputChannel;
    }
    
    
    /**
     * @access public
     * @return 
     */
    public function getOutputChannel(){
        return $this->outputChannel;
    }
    

    
    /**
     * @access protected
     * @param $content 
     * @return 
     */
    protected function replyMessage($content){
        $message = $this->ensureMessage($content);      
        $this->getOutputChannel()->send($message);      
    }

    
    /**
     * @access protected
     * @param $message 
     * @return 
     */
    protected function ensureMessage($message){
        return ($message instanceof PEIP_INF_Message) ? $message : $this->buildMessage($message);   
    }
    
    
    /**
     * @access protected
     * @param $content 
     * @return 
     */
    protected function buildMessage($content){
        return $this->getMessageBuilder()->setContent($content)->build();   
    }   
    
    
    /**
     * @access protected
     * @return 
     */
    protected function getMessageBuilder(){
        return isset($this->messageBuilder) && ($this->messageBuilder->getMessageClass() == $this->getMessageClass())
            ? $this->messageBuilder
            : $this->messageBuilder = PEIP_Message_Builder::getInstance($this->messageClass);
    }
    
    
    
    /**
     * @access public
     * @param $messageClass 
     * @return 
     */
    public function setMessageClass($messageClass){
        $this->messageClass = $messageClass;
    }

    
    /**
     * @access public
     * @return 
     */
    public function getMessageClass(){
        return $this->messageClass;
    }       

    
    /**
     * @access protected
     * @param $message 
     * @return 
     */
    protected function doHandle(PEIP_INF_Message $message){
        $this->doReply($message);
    }
    
    
    /**
     * @access protected
     * @param $message 
     * @return 
     */
    abstract protected function doReply(PEIP_INF_Message $message);
    
    
}
