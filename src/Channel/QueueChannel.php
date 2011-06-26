<?php

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * QueueChannel 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 * @extends \PEIP\ABS\Channel\PollableChannel
 * @implements \PEIP\INF\Channel\PollableChannel, \PEIP\INF\Channel\Channel, \PEIP\INF\Event\Connectable
 */



namespace PEIP\Channel;

class QueueChannel 
    extends \PEIP\ABS\Channel\PollableChannel {

    protected 
        $capacity,
        $queue; 
        
    
    /**
     * @access public
     * @param $capacity 
     * @return 
     */
    public function __construct($capacity = -1){
        $this->setCapacity((int)$capacity);
        $this->queue = new SplQueue();  
    }   
        
    
    /**
     * @access public
     * @return 
     */
    public function getMessageCount(){
        return count($this->messages);
    }   

    
    /**
     * @access public
     * @return 
     */
    public function getCapacity(){
        return $this->capacity;
    }       

    
    /**
     * @access public
     * @param $capacity 
     * @return 
     */
    public function setCapacity($capacity){
        $this->capacity = $capacity;
    }   

    
    /**
     * @access protected
     * @param $message 
     * @return 
     */
    protected function doSend(\PEIP\INF\Message\Message $message){
        if($this->capacity < 1 || $this->getMessageCount() <= $this->getCapacity()){
            $this->queue->enqueque($message);
        }else{
            throw new Exception('Not implemented yet.');
        }            
    }       
} 
