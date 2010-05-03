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
     
    protected 
        $eventDispatcher,
        $messageDispatcher,
        $name,
        $commands = array();

    protected static 
        $sharedEventDispatcher; 
        
    
    /**
     * sets Name of the Pipe
     * 
     * @access public
     * @param string $name the name of the pipe 
     */
    public function setName($name){
        $this->name = $name;
    }
       
    /**
     * returns name of the Pipe
     * 
     * @access public
     * @return string the name of the pipe 
     */
    public function getName(){
        return $this->name;
    }
  
    /**
     * Sends a message on the Pipe.
     * Implements PEIP_INF_Channel
     * 
     * @implements PEIP_INF_Channel
     * @access public
     * @param $message 
     * @param $timeout 
     * @return 
     */
    public function send(PEIP_INF_Message $message, $timeout = -1){
        return $this->handle($message);
    }
  
    /**
     * Publishes a message to all message subscribers
     * 
     * @event prePublish
     * @event postPublish
     * @access protected
     * @param PEIP_INF_Message $message the message to publish
     * @return boolean 
     */
    protected function doSend(PEIP_INF_Message $message){
        $this->doFireEvent('prePublish', array('MESSAGE'=>$message));
        $this->getMessageDispatcher()->notify($message);
        $this->doFireEvent('postPublish', array('MESSAGE'=>$message));
        return true;
    }
      
    /**
     * Creates and sends a reply message from a given content/payload.
     * Sends message through output channel if set,
     * else publishes message to message subscribers.
     * 
     * @access protected
     * @param mixed $content content/payload for the message 
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
     * Subscribes a listener to the Pipe.
     * 
     * @implements PEIP_INF_Subscribable_Channel
     * @event subscribe
     * @access public
     * @param PEIP_INF_Handler $handler the listener/handler to subscribe to the channel
     */
    public function subscribe(PEIP_INF_Handler $handler){
        $this->getMessageDispatcher()->connect($handler);
        $this->doFireEvent('subscribe', array('SUBSCRIBER'=>$handler));
    } 
    
    /**
     * Unsubscribes a listener from the Pipe.
     * 
     * @implements PEIP_INF_Subscribable_Channel
     * @event unsubscribe
     * @access public
     * @param PEIP_INF_Handler $handler the listener/handler to unsubscribe from the channel
     */
    public function unsubscribe(PEIP_INF_Handler $handler){
        $this->getMessageDispatcher()->disconnect($handler);
        $this->doFireEvent('unsubscribe', array('SUBSCRIBER'=>$handler));       
    }
     
    /**
     * Sets the (message) dispatcher for the Pipe.
     * 
     * @access public
     * @param PEIP_INF_Dispatcher $dispatcher the (message) dispatcher
     * @param boolean $transferListeners wether transfer listners from previous dispatcher. default: true 
     */
    public function setMessageDispatcher(PEIP_INF_Dispatcher $dispatcher, $transferListeners = true){
        if(isset($this->dispatcher) && $transferListeners){
            foreach($this->dispatcher->getListeners() as $listener){
                $dispatcher->connect($listener);
                $this->dispatcher->disconnect($listener);       
            }   
        }
        $this->dispatcher = $dispatcher;
        $this->doFireEvent('setMessageDispatcher', array('DISPATCHER'=>$dispatcher));       
    }   
      
    /**
     * Returns the (message) dispatcher for the Pipe.
     * 
     * @access public
     * @return 
     */
    public function getMessageDispatcher(){
        return isset($this->dispatcher) ? $this->dispatcher : $this->dispatcher = new PEIP_Dispatcher;
    }   
      
    /**
     * Registers event listeners for a given event of the Pipe.
     * 
     * @implements PEIP_INF_Connectable
     * @access public
     * @param string $name name of the event 
     * @param PEIP_INF_Handler $listener the event listener
     */
    public function connect($name, PEIP_INF_Handler $listener){
        $this->getEventDispatcher()->connect($name, $this, $listener);
        $this->doFireEvent('connect', array('EVENT'=>$name, 'LISTENER'=>$handler));     
    }   
 
    /**
     * Unregisters event listeners for a given event of the Pipe.
     * 
     * @implements PEIP_INF_Connectable
     * @access public
     * @param string $name name of the event 
     * @param PEIP_INF_Handler $listener the event listener
     */
    public function disconnect($name, PEIP_INF_Handler $listener){
        $this->getEventDispatcher()->disconnect($name, $this, $listener);
        $this->doFireEvent('disconnect', array('EVENT'=>$name, 'LISTENER'=>$handler));      
    }   
  
    /**
     * Checks wether a given event has a registered event listener.
     * 
     * @access public
     * @param string $name name of the event 
     * @return boolean wether the event has a listener
     */
    public function hasListeners($name){
        return $this->getEventDispatcher()->hasListener($name, $this);      
    }
   
    /**
     * Returns all listeners for a given event.
     * 
     * @access public
     * @param string $name name of the event 
     * @return array array of event listeners 
     */
    public function getListeners($name){
        return $this->getEventDispatcher()->hasListener($name, $this);      
    }   
    
    /**
     * Registers a callable as event listener for a given event.
     * 
     * @access public
     * @param string $name name of the event 
     * @param callable $callable the callable to register as event listener 
     */
    public function connectCall($eventName, $callable){
        $this->connect($eventName, new PEIP_Callable_Handler($callable));   
    }
    
    /**
     * Unregisters a callable as event listener for a given event.
     * 
     * @access public
     * @param string $name name of the event 
     * @param callable $callable the callable to register as event listener 
     */
    public function disconnectCall($eventName, $callable){
        foreach($this->getEventDispatcher()->getListeners() as $handler){
            if($handler instanceof PEIP_Callable_Handler && $handler->getCallable() == $callable){
                $this->disconnect($eventName, $this, $handler); 
            }
        }
    }   
  
    /**
     * Registers a callable as executor for a given command.
     * 
     * @access protected
     * @param string $commandName the name of the command 
     * @param callable $callable the callable to rgister as executor 
     */
    protected function registerCommand($commandName, $callable){
        $this->commands[$commandName] = $callable;  
    }
      
    /**
     * Executes a command given by a message on this Pipe.
     * Note: The command will be resolved from the message`s header 'COMMAND'. 
     * 
     * @event preCommand
     * @event postCommand
     * @access public
     * @param PEIP_INF_Message $cmdMessage the message with the command
     */
    public function command(PEIP_INF_Message $cmdMessage){
        $this->doFireEvent('preCommand', array('MESSAGE'=>$cmdMessage));
        $cmd = trim((string)$cmdMessage->getHeader('COMMAND'));
        if($cmd != '' && array_key_exists($cmd, $this->commands)){
            call_user_func($this->commands[$commandName], $cmdMessage->getContent());   
        }
        $this->doFireEvent('postCommand', array('MESSAGE'=>$cmdMessage));
    }
       
    /**
     * Sets the event dipatcher for this Pipe.
     * 
     * @event setEventDispatcher
     * @access public
     * @param PEIP_Object_Event_Dispatcher $dispatcher the event dispatcher
     * @param boolean $transferListeners wether transfer listners from previous dispatcher. default: true 
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
        $this->doFireEvent('setEventDispatcher', array('DISPATCHER'=>$dispatcher)); 
    }
       
    /**
     * Returns the event dipatcher for this Pipe.
     * 
     * @access public
     * @return PEIP_Object_Event_Dispatcher the event dispatcher for this Pipe.
     */
    public function getEventDispatcher(){
        return $this->eventDispatcher ? $this->eventDispatcher : $this->eventDispatcher = self::getSharedEventDispatcher();
    }   
  
     /**
     * Returns the shared (static singleton) event dispatcher for this Pipe.
     * 
     * @access protected
     * @return PEIP_Object_Event_Dispatcher the shared event dispatcher for this Pipe.
     */   
    protected static function getSharedEventDispatcher(){
        return self::$sharedEventDispatcher ? self::$sharedEventDispatcher : self::$sharedEventDispatcher = new PEIP_Object_Event_Dispatcher; 
    }  
    
    /**
     * Does publish an given event on this Pipe.
     * 
     * @access protected
     * @param string $name the name of the event 
     * @param array $headers headers for the event as key/value pairs 
     * @param string $eventClass the event class to create instance from. default: the default event class for this Pipe.
     * @return 
     */
    protected function doFireEvent($name, array $headers = array(), $eventClass = false){
        return $this->getEventDispatcher()->buildAndNotify($name, $this, $headers, $eventClass);
    }       
    
}   
