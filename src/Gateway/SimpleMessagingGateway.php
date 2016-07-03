<?php

namespace PEIP\Gateway;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * SimpleMessagingGateway 
 * Basic implementation of a messaging gateway
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage gateway 
 * @implements \PEIP\INF\Gateway\MessagingGateway, \PEIP\INF\Message\MessageBuilder
 */

use PEIP\Message\MessageBuilder;

class SimpleMessagingGateway 
    implements 
        \PEIP\INF\Gateway\MessagingGateway,
        \PEIP\INF\Message\MessageBuilder {

    protected 
        $requestChannel,
        $replyChannel,
        $messageClass = '\PEIP\Message\GenericMessage',
        $defaultHeaders,
        $messageBuilder; 
  
    /**
     * constructor
     * 
     * @access public
     * @param \PEIP\INF\Channel\Channel $requestChannel The default channel to send requests from the gateway
     * @param \PEIP\INF\Channel\PollableChannel $replyChannel The default channel to receive requests from the gateway
     * @param array $defaultHeaders The default headers to apply to request messages 
     */
    public function __construct(\PEIP\INF\Channel\Channel $requestChannel, \PEIP\INF\Channel\Channel $replyChannel = NULL, array $defaultHeaders = array()) {
        $this->setRequestChannel($requestChannel);
        if ($replyChannel) {
            $this->setReplyChannel($replyChannel);
        }     
        $this->defaultHeaders = $defaultHeaders;
        $this->messageBuilder = MessageBuilder::getInstance($this->messageClass);
    }   
              
    /**
     * sets the channel to send requests from the gateway
     * 
     * @access public
     * @return 
     */
    public function setRequestChannel(\PEIP\INF\Channel\Channel $requestChannel) {
        $this->requestChannel = $requestChannel;
    }
  
    /**
     * sets the default channel to receive requests from the gateway
     * 
     * @access public
     * @param \PEIP\INF\Channel\PollableChannel $replyChannel The default channel to receive requests from the gateway
     * @return 
     */
    public function setReplyChannel(\PEIP\INF\Channel\Channel $replyChannel) {
        if (!($replyChannel instanceof \PEIP\INF\Channel\PollableChannel)) {
            throw new \InvalidArgumentException('reply channel must be instance of \PEIP\INF\Channel\PollableChannel.');
        }       
        $this->replyChannel = $replyChannel;
    }
 
    /**
     * sends a request/message through the gateway
     * 
     * @access public
     * @param mixed $content the content/payload for the message to send 
     * @return 
     */
    public function send($content) {
        return $this->requestChannel->send($this->buildMessage($content));
    }
   
    /**
     * receives a request/message from the gateway
     * 
     * @access public
     * @return mixed content/payload of the received message
     */
    public function receive() {
        if (!isset($this->replyChannel)) {
            throw new \LogicException('No replyChannel set.');
        }       
        $message = $this->replyChannel->receive();
        if ($message) {
            return $message->getContent();
        }
        return NULL;
    }
    
    /**
     * sends and receives a request/message through the gateway
     * 
     * @access public
     * @param \Order $content the content/payload for the message to send 
     * @return mixed content/payload of the received message
     */
    public function sendAndReceive($content) {
        $this->send($content);
        try {
            $res = $this->receive();
        } catch (\Exception $e) {
            return NULL;
        }
        return $res;
    }
  
    /**
     * builds the message to send from given content/payload
     * 
     * @access protected
     * @param mixed $content the content/payload for the message to send 
     * @return \PEIP\INF\Message\Message the built message
     */
    protected function buildMessage($content) {
        return $this->getMessageBuilder()->setContent($content)->build();   
    }   
      
    /**
     * returns the message builder instance for the registerd message class.
     * 
     * @access protected
     * @return MessageBuilder message builder instance for the registerd message class
     */
    protected function getMessageBuilder() {
        return isset($this->messageBuilder) && ($this->messageBuilder->getMessageClass() == $this->getMessageClass())
            ? $this->messageBuilder
            : $this->messageBuilder = MessageBuilder::getInstance($this->messageClass)->setHeaders($this->defaultHeaders);
    }
        
    /**
     * registers the message class to create instances from by the gateway
     * 
     * @access  public
     * @param   string $messageClass message class to create instances from
     * @return 
     */
    public function setMessageClass($messageClass) {
        $this->messageClass = $messageClass;
    }
    
    /**
     * returns the message class to create instances from
     * 
     * @access public
     * @return string message class to create instances from
     */
    public function getMessageClass() {
        return $this->messageClass;
    }   

}
