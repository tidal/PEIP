<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * PEIP_ABS_Interceptable_Message_Channel 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 * @implements PEIP_INF_Channel, PEIP_INF_Interceptable, PEIP_INF_Connectable
 */

abstract class PEIP_ABS_Interceptable_Message_Channel 
    implements 
        PEIP_INF_Channel,
        PEIP_INF_Interceptable,
        PEIP_INF_Connectable {

    protected 
        $eventDispatcher,
        $interceptorDispatcher,
        $name,
        $interceptors = array();
    
    protected static 
        $sharedEventDispatcher; 

    
    /**
     * @access public
     * @param $name 
     * @return 
     */
    public function __construct($name){
        $this->name = $name;
    }        
    
    /**
     * @access public
     * @return string the channel�s name
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @access public
     * @param PEIP_Interceptor_Dispatcher $dispatcher 
     * @return void
     */
    public function setInterceptorDispatcher(PEIP_Interceptor_Dispatcher $dispatcher){
        $this->interceptorDispatcher = $dispatcher;
    }
    
    
    /**
     * @access public
     * @return PEIP_Interceptor_Dispatcher dispatcher
     */
    public function getInterceptorDispatcher(){
        return is_object($this->interceptorDispatcher) ? $this->interceptorDispatcher : $this->interceptorDispatcher = new PEIP_Interceptor_Dispatcher();
    }   
    
    
    /**
     * @access protected
     * @param PEIP_INF_Message $message 
     * @param string $eventName 
     * @param array $parameters 
     * @return 
     */
    protected function dispatchInterceptor(PEIP_INF_Message $message, $eventName, array $parameters = array()){
        array_unshift($parameters, $message, $this); 
        return $this->getInterceptorDispatcher()->notify($eventName, $parameters);
    }
    
    
    /**
     * @access public
     * @param PEIP_INF_Message $message 
     * @param integer $timeout 
     * @return 
     */
    public function send(PEIP_INF_Message $message, $timeout = -1){
        $this->dispatchInterceptor($message, 'preSend');
        $this->doFireEvent('preSend', array('MESSAGE'=>$message));
        $sent = $this->doSend($message);
        $this->dispatchInterceptor($message, 'postSend', array('sent' => $sent));
        $this->doFireEvent('postSend', array('MESSAGE'=>$message, 'SENT' => $sent));
    }

    
    /**
     * @access protected
     * @param PEIP_INF_Message $message 
     * @return 
     */
    abstract protected function doSend(PEIP_INF_Message $message);
    
    
    /**
     * @access public
     * @param PEIP_Abstract_Message_Channel_Interceptor $interceptor 
     * @return 
     */
    public function addInterceptor(PEIP_INF_Channel_Interceptor $interceptor){
        
        $hash = spl_object_hash($interceptor);
        $this->interceptors[$hash] = $interceptor;      
        $this->interceptorsHandlers[$hash] = array();
        foreach(array('preSend', 'postSend') as $event){
            $handler = new PEIP_Callable_Message_Handler(array($interceptor, $event));
            $this->connectInterceptor($event, $handler); 
            $this->interceptorsHandlers[$hash][$event]  = $handler;
        }
    }

    
    /**
     * @access public
     * @param string $eventName 
     * @param mixed $handler 
     * @return 
     */
    public function connectInterceptor($eventName, $handler){
        $this->getInterceptorDispatcher()->connect($eventName, $handler);   
    }
     
    /**
     * @access public
     * @param PEIP_Abstract_Message_Channel_Interceptor $interceptor 
     * @return 
     */
    public function deleteInterceptor(PEIP_INF_Channel_Interceptor $interceptor){
        $hash = spl_object_hash($interceptor);
        $handlers = $this->interceptorsHandlers[$hash];
        $this->getInterceptorDispatcher()->disconnect('preSend', $handlers['preSend']);
        $this->getInterceptorDispatcher()->disconnect('postSend', $handlers['postSend']);
        unset($this->interceptors[$hash]); 
        unset($this->interceptors[$hash]);
    }
    
    /**
     * @access public
     * @return array PEIP_Abstract_Message_Channel_Interceptor[] 
     */
    public function getInterceptors(){
        return array_values($this->interceptors);
    }
      
    /**
     * @access public
     * @param array $interceptors PEIP_Abstract_Message_Channel_Interceptor[] 
     * @return 
     */
    public function setInterceptors(array $interceptors){
        $this->clearInterceptors();
        foreach($interceptors as $interceptor){
            $this->addInterceptor($interceptor);
        }
    }
         
    /**
     * @access public
     * @return 
     */
    public function clearInterceptors(){
        foreach($this->interceptors as $interceptor){
            $this->deleteInterceptor($interceptor);
        }
    }
  
    /**
     * @access public
     * @param string $name 
     * @param PEIP_INF_Handler $listener 
     * @return 
     */
    public function connect($name, PEIP_INF_Handler $listener){
        return $this->getEventDispatcher()->connect($name, $this, $listener);
    }   
 
    /**
     * @access public
     * @param string $name 
     * @param PEIP_INF_Handler $listener 
     * @return 
     */
    public function disconnect($name, PEIP_INF_Handler $listener){
        return $this->getEventDispatcher()->disconnect($name, $this, $listener);
    }   
    
    /**
     * @access public
     * @param string $name 
     * @return 
     */
    public function hasListeners($name){
        return $this->getEventDispatcher()->hasListeners($name, $this);
    }
       
    /**
     * @access public
     * @param string $name 
     * @return 
     */
    public function getListeners($name){
        return $this->getEventDispatcher()->getListeners($name, $this);
    }
        
    /**
     * @access public
     * @param PEIP_Object_Event_Dispatcher $dispatcher 
     * @param boolean $transferListners wether to transfer given Listeners to new dispatcher
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
    }
       
    /**
     * @access public
     * @return PEIP_Object_Event_Dispatcher
     */
    public function getEventDispatcher(){
        return $this->eventDispatcher ? $this->eventDispatcher : $this->eventDispatcher = self::getSharedEventDispatcher();
    }   

    /**
     * @access protected
     * @static
     * @return PEIP_Object_Event_Dispatcher
     */    
    protected static function getSharedEventDispatcher(){
        return self::$sharedEventDispatcher ? self::$sharedEventDispatcher : self::$sharedEventDispatcher = new PEIP_Object_Event_Dispatcher; 
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