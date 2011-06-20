<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Queue_Channel 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 * @extends PEIP_ABS_Pollable_Channel
 * @implements PEIP_INF_Pollable_Channel, PEIP_INF_Channel, PEIP_INF_Connectable
 */


class PEIP_Queue_Channel 
    extends PEIP_ABS_Pollable_Channel {

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
    protected function doSend(PEIP_INF_Message $message){
        if($this->capacity < 1 || $this->getMessageCount() <= $this->getCapacity()){
            $this->queue->enqueque($message);
        }else{
            throw new Exception('Not implemented yet.');
        }            
    }       
} 
