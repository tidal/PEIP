<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Pipe 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage pipe 
 * @extends PEIP_ABS_Reply_Producing_Message_Handler
 * @implements PEIP_INF_Message_Builder, PEIP_INF_Handler, PEIP_INF_Channel, PEIP_INF_Subscribable_Channel, PEIP_INF_Connectable
 */


class PEIP_Pipe 
    extends PEIP_ABS_Reply_Producing_Message_Handler 
    implements 
        PEIP_INF_Channel,
        PEIP_INF_Subscribable_Channel,
        PEIP_INF_Connectable {

    const 
        DEFAULT_CLASS_MESSAGE_DISPATCHER = 'PEIP_Dispatcher',
        DEFAULT_CLASS_EVENT_DISPATCHER = 'PEIP_Object_Event_Dispatcher',
        EVENT_PRE_PUBLISH = 'prePublish',
        EVENT_POST_PUBLISH = 'postPublish',
        EVENT_SUBSCRIBE = 'subscribe',
        EVENT_UNSUBSCRIBE = 'unsubscribe',
        EVENT_CONNECT = 'connect',
        EVENT_DISCONNECT = 'disconnect',
        EVENT_PRE_COMMAND = 'preCommand',
        EVENT_POST_COMMAND = 'postCommand',
        EVENT_SET_MESSAGE_DISPATCHER = 'setMessageDispatcher',
        EVENT_SET_EVENT_DISPATCHER = 'setEventDispatcher',
        HEADER_MESSAGE = 'MESSAGE',
        HEADER_SUBSCRIBER = 'SUBSCRIBER',
        HEADER_DISPATCHER = 'DISPATCHER',
        HEADER_LISTENER = 'LISTENER',
        HEADER_EVENT = 'EVENT';
     
    protected 
        $eventDispatcher,
        $messageDispatcher,
        $name,
        $commands = array();

    protected static 
        $sharedEventDispatcher; 
        
    
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
    public function send(PEIP_INF_Message $message, $timeout = -1){
        return $this->handle($message);
    }


    /**
     * @access protected
     * @param $message 
     * @return 
     */
    protected function doSend(PEIP_INF_Message $message){
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
    protected function doReply(PEIP_INF_Message $message){
        $this->replyMessage($message);
    }

    
    /**
     * @access public
     * @param $handler 
     * @return 
     */
    public function subscribe(PEIP_INF_Handler $handler){
        $this->getMessageDispatcher()->connect($handler);
        $this->doFireEvent(self::EVENT_SUBSCRIBE, array(self::HEADER_SUBSCRIBER=>$handler));
    }
    
    
    /**
     * @access public
     * @param $handler e
     * @return 
     */
    public function unsubscribe(PEIP_INF_Handler $handler){
        $this->getMessageDispatcher()->disconnect($handler);
        $this->doFireEvent(self::EVENT_UNSUBSCRIBE, array(self::HEADER_SUBSCRIBER=>$handler));       
    }
    
    
    /**
     * @access public
     * @param $dispatcher 
     * @param $transferListeners 
     * @return 
     */
    public function setMessageDispatcher(PEIP_INF_Dispatcher $dispatcher, $transferListeners = true){
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
     * @access public
     * @param $name 
     * @param $listener 
     * @return 
     */
    public function connect($name, PEIP_INF_Handler $listener){
        $this->getEventDispatcher()->connect($name, $this, $listener);
        $this->doFireEvent(self::EVENT_CONNECT, array(self::HEADER_EVENT=>$name, self::HEADER_LISTENER=>$handler));     
    }   

    
    /**
     * @access public
     * @param $name 
     * @param $listener 
     * @return 
     */
    public function disconnect($name, PEIP_INF_Handler $listener){
        $this->getEventDispatcher()->disconnect($name, $this, $listener);
        $this->doFireEvent(self::EVENT_DISCONNECT, array(self::HEADER_EVENT=>$name, self::HEADER_LISTENER=>$handler));      
    }   

    
    /**
     * @access public
     * @param $name 
     * @return 
     */
    public function hasListeners($name){
        return $this->getEventDispatcher()->hasListener($name, $this);      
    }

    
    /**
     * @access public
     * @param $name 
     * @return 
     */
    public function getListeners($name){
        return $this->getEventDispatcher()->hasListener($name, $this);      
    }   
    
    /**
     * @access public
     * @param $eventName 
     * @param $callable 
     * @return 
     */
    public function connectCall($eventName, $callable){
        $this->connect($eventName, new PEIP_Callable_Handler($callable));   
    }
    
    /**
     * @access public
     * @param $eventName 
     * @param $callable 
     * @return 
     */
    public function disconnectCall($eventName, $callable){
        foreach($this->getEventDispatcher()->getListeners() as $handler){
            if($handler instanceof PEIP_Callable_Handler && $handler->getCallable() == $callable){
                $this->disconnect($eventName, $this, $handler); 
            }
        }
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
    public function command(PEIP_INF_Message $cmdMessage){
        $this->doFireEvent(self::EVENT_PRE_COMMAND, array(self::HEADER_MESSAGE=>$cmdMessage));
        $commandName = trim((string)$cmdMessage->getHeader('COMMAND'));
        if($commandName != '' && array_key_exists($commandName, $this->commands)){
            call_user_func($this->commands[$commandName], $cmdMessage->getContent());   
        }
        $this->doFireEvent(self::EVENT_POST_COMMAND, array(self::HEADER_MESSAGE=>$cmdMessage));
    }
    
    
    /**
     * @access public
     * @param $dispatcher 
     * @param $transferListners 
     * @return 
     */
    public function setEventDispatcher(PEIP_Object_Event_Dispatcher $dispatcher, $transferListners = true){
        if($transferListners){
            foreach($this->eventDispatcher->getEventNames($this) as $name){
                if($this->eventDispatcher->hasListeners($name, $this)){
                    foreach($this->eventDispatcher->getListeners($name, $this) as $listener){
                        $dispatcher->connect($name, $this, $listener);  
                    }
                }       
            }   
        }   
        $this->eventDispatcher = $dispatcher;   
        $this->doFireEvent(self::EVENT_SET_EVENT_DISPATCHER, array(self::HEADER_DISPATCHER=>$dispatcher)); 
    }
    
    
    /**
     * @access public
     * @return 
     */
    public function getEventDispatcher(){
        return $this->eventDispatcher ? $this->eventDispatcher : $this->eventDispatcher = self::getSharedEventDispatcher();
    }   
    
    protected static function getSharedEventDispatcher(){
        $defaultDispatcher = self::DEFAULT_CLASS_EVENT_DISPATCHER;
        return self::$sharedEventDispatcher ? self::$sharedEventDispatcher : self::$sharedEventDispatcher = new $defaultDispatcher;
    }

    
    /**
     * @access protected
     * @param $name 
     * @param $headers 
     * @param $eventClass 
     * @return 
     */
    protected function doFireEvent($name, array $headers = array(), $eventClass = false){
        return $this->getEventDispatcher()->buildAndNotify($name, $this, $headers, $eventClass);
    }       
    
}   
