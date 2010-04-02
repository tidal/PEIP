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
        $messageClass = 'PEIP_Generic_Message',
        $replyChannelHeaders = array('REPLY_CHANNEL');

    
    /**
     * @access public
     * @param PEIP_INF_Channel $outputChannel 
     * @return PEIP_ABS_Reply_Producing_Message_Handler
     */
    public function setOutputChannel(PEIP_INF_Channel $outputChannel){
        $this->doSetOutputChannel($outputChannel);
        return $this;
    }   

    
    /**
     * @access protected
     * @param PEIP_INF_Channel $outputChannel 
     * @return void
     */
    protected function doSetOutputChannel(PEIP_INF_Channel $outputChannel){
        $this->outputChannel = $outputChannel;
    }
    
    
    /**
     * @access public
     * @return PEIP_INF_Channel
     */
    public function getOutputChannel(){
        return $this->outputChannel;
    }

    /**
     * @access protected
     * @param PEIP_INF_Message $message 
     * @return PEIP_INF_Channel
     */    
	protected function doGetOutputChannel(PEIP_INF_Message $message){
		$replyChannel = $this->resolveReplyChannel($message);
		return $replyChannel ? $replyChannel : $this->getOutputChannel();		
	}

    /**
     * @access protected
     * @param PEIP_INF_Message $message 
     * @return PEIP_INF_Channel
     */ 	
	protected function resolveReplyChannel(PEIP_INF_Message $message){
		foreach($this->replyChannelHeaders as $header){
			if($message->hasHeader($header)){
				return $message->getHeader($header);
			}
		}
		return NULL;
	}
		
    /**
     * @access protected
     * @param $content 
     * @return 
     */
    protected function replyMessage($content){
        $message = $this->ensureMessage($content);      
        $this->doGetOutputChannel($message)->send($message);      
    }

    
    /**
     * @access protected
     * @param PEIP_INF_Message $message 
     * @return PEIP_INF_Message
     */
    protected function ensureMessage($message){
        return ($message instanceof PEIP_INF_Message) ? $message : $this->buildMessage($message);   
    }
    
    
    /**
     * @access protected
     * @param mixed $content 
     * @return PEIP_INF_Message
     */
    protected function buildMessage($content){
        return $this->getMessageBuilder()->setContent($content)->build();   
    }   
    
    
    /**
     * @access protected
     * @return PEIP_Message_Builder
     */
    protected function getMessageBuilder(){
        return isset($this->messageBuilder) && ($this->messageBuilder->getMessageClass() == $this->getMessageClass())
            ? $this->messageBuilder
            : $this->messageBuilder = PEIP_Message_Builder::getInstance($this->messageClass);
    }
      
    /**
     * @access public
     * @param $messageClass 
     * @return PEIP_ABS_Reply_Producing_Message_Handler
     */
    public function setMessageClass($messageClass){
        $this->messageClass = $messageClass;
        return $this;
    }

    
    /**
     * @access public
     * @return 
     */
    public function getMessageClass(){
        return $this->messageClass;
    }       

    /**
     * @access public
     * @param string $headerName 
     * @return void
     */
    public function addReplyChannelHeader($headerName){
        $this->replyChannelHeaders[] = $headerName;
    }

    
    /**
     * @access public
     * @param array $headerNames 
     * @return PEIP_ABS_Reply_Producing_Message_Handler
     */
    public function setReplyChannelHeaders(array $headerNames){
        $this->replyChannelHeaders = $headerNames;
        return $this;
    } 

    /**
     * @access public
     * @return array
     */
    public function getReplyChannelHeaders(){
        return $this->replyChannelHeaders;
    }
    
    
    
    /**
     * @access protected
     * @param PEIP_INF_Message $message 
     * @return 
     */
    protected function doHandle(PEIP_INF_Message $message){
        $this->doReply($message);
    }
    
    
    /**
     * @access protected
     * @param PEIP_INF_Message $message 
     * @return 
     */
    abstract protected function doReply(PEIP_INF_Message $message);
    
    
}
