<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Simple_Messaging_Gateway 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage gateway 
 * @implements PEIP_INF_Messaging_Gateway, PEIP_INF_Message_Builder
 */


class PEIP_Simple_Messaging_Gateway 
    implements 
        PEIP_INF_Messaging_Gateway,
        PEIP_INF_Message_Builder {

    protected 
        $requestChannel,
        $replyChannel,
        $messageClass = 'PEIP_Generic_Message',
        $defaultHeaders,
        $messageBuilder; 

    
    /**
     * @access public
     * @param $requestChannel 
     * @param $replyChannel 
     * @param $defaultHeaders 
     * @return 
     */
    public function __construct(PEIP_INF_Channel $requestChannel, PEIP_INF_Channel $replyChannel = NULL, array $defaultHeaders = array()){
        $this->setRequestChannel($requestChannel);
        $this->setReplyChannel($replyChannel);
        $this->defaultHeaders = $defaultHeaders;
        $this->messageBuilder = PEIP_Message_Builder::getInstance($this->messageClass);
    }   
            
    
    /**
     * @access public
     * @param $requestChannel 
     * @return 
     */
    public function setRequestChannel(PEIP_INF_Channel $requestChannel){
        $this->requestChannel = $requestChannel;
    }

    
    /**
     * @access public
     * @param $replyChannel 
     * @return 
     */
    public function setReplyChannel(PEIP_INF_Channel $replyChannel){
        if(!($replyChannel instanceof PEIP_INF_Pollable_Channel)){
            throw new InvalidArgumentException('reply channel must be instance of PEIP_INF_Pollable_Channel.');
        }       
        $this->replyChannel = $replyChannel;
    }

    
    /**
     * @access public
     * @param $content 
     * @return 
     */
    public function send($content){
        return $this->requestChannel->send($this->buildMessage($content));
    }

    
    /**
     * @access public
     * @return 
     */
    public function receive(){
        if(!isset($this->replyChannel)){
            throw new LogicException('No replyChannel set.');
        }       
        $message = $this->replyChannel->receive();
        if($message){
            return $message;
        }
        
        //return $this->replyChannel->receive()->getContent();
    }
    
    
    /**
     * @access public
     * @param $content 
     * @return 
     */
    
    /**
     * @access public
     * @param $content 
     * @return 
     */
    public function sendAndReceive($content){
        $this->send($content);
        try {
            $res = $this->receive();
        }
        catch(Exception $e){
            return NULL;
        }
        return $res;
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
            : $this->messageBuilder = PEIP_Message_Builder::getInstance($this->messageClass)->setHeaders($this->defaultHeaders);
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

}
