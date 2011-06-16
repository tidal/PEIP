<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_ABS_Subscribable_Channel 
 * Abstract base class for subscribable channels
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 * @extends PEIP_ABS_Interceptable_Message_Channel
 * @implements PEIP_INF_Connectable, PEIP_INF_Interceptable, PEIP_INF_Channel, PEIP_INF_Subscribable_Channel
 */


abstract class PEIP_ABS_Subscribable_Channel 
    extends PEIP_ABS_Interceptable_Message_Channel 
    implements PEIP_INF_Subscribable_Channel{

    protected $messageDispatcher;   
       
    /**
     * Subscribes a given listener to the channel
     * 
     * @event subscribe
     * @access public
     * @param Callable|PEIP_INF_Handler  $handler the listener to subscribe
     * @return 
     */
    public function subscribe($handler){ 
        PEIP_Test::ensureHandler($handler);
        $this->getMessageDispatcher()->connect($handler);
        $this->doFireEvent('subscribe', array('SUBSCRIBER'=>$handler));
    }
      
    /**
     * Unsubscribes a given listener from the channel
     * 
     * @event unsubscribe
     * @access public
     * @param Callable|PEIP_INF_Handler  $handler the listener to unsubscribe
     * @return 
     */
    public function unsubscribe($handler){
        PEIP_Test::ensureHandler($handler);
        $this->getMessageDispatcher()->disconnect($handler);
        $this->doFireEvent('unsubscribe', array('SUBSCRIBER'=>$handler));       
    }
      
    /**
     * Sets the message dispatcher resposible for notifying all subscribers about new messages.
     * 
     * @access public
     * @param PEIP_INF_Dispatcher $dispatcher instance of PEIP_INF_Dispatcher
     * @param boolean $transferListeners wether to transfer listeners of old dispatcher (if set) to new one. default: true 
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
    }   
       
    /**
     * Returns the message dispatcher resposible for notifying all subscribers about new messages.
     * 
     * @access public
     * @return 
     */
    public function getMessageDispatcher(){
        return isset($this->dispatcher) ? $this->dispatcher : $this->dispatcher = new PEIP_Dispatcher;
    }   
    
} 
