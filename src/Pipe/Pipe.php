<?php

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Pipe 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage pipe 
 * @extends \PEIP\ABS\Handler\ReplyProducingMessageHandler
 * @implements \PEIP\INF\Message\MessageBuilder, \PEIP\INF\Handler\Handler, \PEIP\INF\Channel\Channel, \PEIP\INF\Channel\SubscribableChannel, \PEIP\INF\Event\Connectable
 * @todo full test-coverage, factor out constants to framework-wide constants
 */


use PEIP\Dispatcher\Dispatcher;
use PEIP\Event\Event;
use PEIP\Util\Test;

namespace PEIP\Pipe;

class Pipe 
    extends \PEIP\ABS\Handler\ReplyProducingMessageHandler 
    implements 
        \PEIP\INF\Channel\Channel,
        \PEIP\INF\Channel\SubscribableChannel,
        \PEIP\INF\Event\Connectable {

    const 
        DEFAULT_CLASS_MESSAGE_DISPATCHER = 'Dispatcher',
        DEFAULT_EVENT_CLASS = 'Event',
        EVENT_PRE_PUBLISH = 'prePublish',
        EVENT_POST_PUBLISH = 'postPublish',
        EVENT_SUBSCRIBE = 'subscribe',
        EVENT_UNSUBSCRIBE = 'unsubscribe',
        EVENT_PRE_COMMAND = 'preCommand',
        EVENT_POST_COMMAND = 'postCommand',
        EVENT_SET_MESSAGE_DISPATCHER = 'setMessageDispatcher',
        EVENT_SET_EVENT_DISPATCHER = 'setEventDispatcher',
        HEADER_MESSAGE = 'MESSAGE',
        HEADER_SUBSCRIBER = 'SUBSCRIBER';
     
    protected 
        $eventDispatcher,
        $messageDispatcher,
        $name,
        $commands = array();

 
        
    
    /**
     * @access public
     * @param $name 
     * @return 
     */
    public function setName($name){
        $this->name = $name;
    }
    
    
    /**
     * @access public
     * @return 
     */
    public function getName(){
        return $this->name;
    }

    
    /**
     * @access public
     * @param $message 
     * @param $timeout 
     * @return 
     */
    public function send(\PEIP\INF\Message\Message $message, $timeout = -1){
        return $this->handle($message);
    }


    /**
     * @access protected
     * @param $message 
     * @return 
     */
    protected function doSend(\PEIP\INF\Message\Message $message){
        $this->doFireEvent(self::EVENT_PRE_PUBLISH, array(self::HEADER_MESSAGE=>$message));
        $this->getMessageDispatcher()->notify($message);
        $this->doFireEvent(self::EVENT_POST_PUBLISH, array(self::HEADER_MESSAGE=>$message));
        return true;
    }
    
    
    /**
     * @access protected
     * @param $content 
     * @return 
     */
    protected function replyMessage($content){
        $message = $this->ensureMessage($content);
        if($this->getOutputChannel()){
            $this->getOutputChannel()->send($message);  
        }else{
            $this->doSend($message);            
        }           
    }
    
    
    /**
     * @access protected
     * @param $message 
     * @return 
     */
    protected function doReply(\PEIP\INF\Message\Message $message){
        $this->replyMessage($message);
    }

    
    /**
     * @access public
     * @param $handler 
     * @return 
     */
    public function subscribe($handler){
        Test::ensureHandler($handler);
        $this->getMessageDispatcher()->connect($handler);
        $this->doFireEvent(self::EVENT_SUBSCRIBE, array(self::HEADER_SUBSCRIBER=>$handler));
    }
    
    
    /**
     * @access public
     * @param $handler e
     * @return 
     */
    public function unsubscribe($handler){
        Test::ensureHandler($handler);
        $this->getMessageDispatcher()->disconnect($handler);
        $this->doFireEvent(
            self::EVENT_UNSUBSCRIBE,
            array(
                self::HEADER_SUBSCRIBER=>$handler
            )
        );
    }
    
    
    /**
     * @access public
     * @param $dispatcher 
     * @param $transferListeners 
     * @return 
     */
    public function setMessageDispatcher(\PEIP\INF\Dispatcher\Dispatcher $dispatcher, $transferListeners = true){
        if(isset($this->dispatcher) && $transferListeners){
            foreach($this->dispatcher->getListeners() as $listener){
                $dispatcher->connect($listener);
                $this->dispatcher->disconnect($listener);       
            }   
        }
        $this->dispatcher = $dispatcher;
        $this->doFireEvent(self::EVENT_SET_MESSAGE_DISPATCHER, array(self::HEADER_DISPATCHER=>$dispatcher));       
    }   
    
    
    /**
     * @access public
     * @return 
     */
    public function getMessageDispatcher(){
        $defaultDispatcher = self::DEFAULT_CLASS_MESSAGE_DISPATCHER;
        return isset($this->dispatcher) ? $this->dispatcher : $this->dispatcher = new $defaultDispatcher;
    }   
    
    
    /**
     * @access protected
     * @param $commandName 
     * @param $callable 
     * @return 
     */
    protected function registerCommand($commandName, $callable){
        $this->commands[$commandName] = $callable;  
    }
    
    
    /**
     * @access public
     * @param $cmdMessage 
     * @return 
     */
    public function command(\PEIP\INF\Message\Message $cmdMessage){
        $this->doFireEvent(self::EVENT_PRE_COMMAND, array(self::HEADER_MESSAGE=>$cmdMessage));
        $commandName = trim((string)$cmdMessage->getHeader('COMMAND'));
        if($commandName != '' && array_key_exists($commandName, $this->commands)){
            call_user_func($this->commands[$commandName], $cmdMessage->getContent());   
        }
        $this->doFireEvent(self::EVENT_POST_COMMAND, array(self::HEADER_MESSAGE=>$cmdMessage));
    }
    
  
    
}   
