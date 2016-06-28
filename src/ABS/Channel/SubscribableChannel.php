<?php

namespace PEIP\ABS\Channel;

namespace PEIP\ABS\Channel;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP\ABS\Channel\SubscribableChannel 
 * Abstract base class for subscribable channels
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 * @extends \PEIP\ABS\Channel\Channel
 * @implements \PEIP\INF\Event\Connectable, \PEIP\INF\Channel\Channel, \PEIP\INF\Channel\SubscribableChannel
 */


use PEIP\Util\Test;
use PEIP\Dispatcher\Dispatcher;

abstract class SubscribableChannel 
    extends \PEIP\ABS\Channel\Channel
    implements \PEIP\INF\Channel\SubscribableChannel{

    protected $messageDispatcher;   
       
    /**
     * Subscribes a given listener to the channel
     * 
     * @event subscribe
     * @access public
     * @param Callable|PEIP\INF\Handler\Handler  $handler the listener to subscribe
     * @return 
     */
    public function subscribe($handler){ 
        Test::ensureHandler($handler);
        $this->getMessageDispatcher()->connect($handler);
        $this->doFireEvent('subscribe', array('SUBSCRIBER'=>$handler));
    }
      
    /**
     * Unsubscribes a given listener from the channel
     * 
     * @event unsubscribe
     * @access public
     * @param Callable|PEIP\INF\Handler\Handler  $handler the listener to unsubscribe
     * @return 
     */
    public function unsubscribe($handler){
        Test::ensureHandler($handler);
        $this->getMessageDispatcher()->disconnect($handler);
        $this->doFireEvent('unsubscribe', array('SUBSCRIBER'=>$handler));       
    }
      
    /**
     * Sets the message dispatcher resposible for notifying all subscribers about new messages.
     * 
     * @access public
     * @param \PEIP\INF\Dispatcher\Dispatcher $dispatcher instance of \PEIP\INF\Dispatcher\Dispatcher
     * @param boolean $transferListeners wether to transfer listeners of old dispatcher (if set) to new one. default: true 
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
    }   
       
    /**
     * Returns the message dispatcher resposible for notifying all subscribers about new messages.
     * 
     * @access public
     * @return 
     */
    public function getMessageDispatcher(){
        return isset($this->dispatcher) ? $this->dispatcher : $this->dispatcher = new Dispatcher;
    }   
    
} 
