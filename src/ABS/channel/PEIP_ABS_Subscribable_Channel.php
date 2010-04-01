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
     * @access public
     * @param $handler 
     * @return 
     */
    public function subscribe(PEIP_INF_Handler $handler){
        $this->getMessageDispatcher()->connect($handler);
        $this->getInterceptorDispatcher()->notify('subscribe', array($this, $handler));
        $this->doFireEvent('subscribe', array('SUBSCRIBER'=>$handler));
    }
    
    
    /**
     * @access public
     * @param $handler 
     * @return 
     */
    public function unsubscribe(PEIP_INF_Handler $handler){
        $this->getMessageDispatcher()->disconnect($handler);
        $this->getInterceptorDispatcher()->notify('unsubscribe', array($this, $handler));
        $this->doFireEvent('unsubscribe', array('SUBSCRIBER'=>$handler));       
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
    }   
    
    
    /**
     * @access public
     * @return 
     */
    public function getMessageDispatcher(){
        return isset($this->dispatcher) ? $this->dispatcher : $this->dispatcher = new PEIP_Dispatcher;
    }   
    
} 
