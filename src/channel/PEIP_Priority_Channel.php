<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Priority_Channel 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 * @extends PEIP_Queue_Channel
 * @implements PEIP_INF_Connectable, PEIP_INF_Interceptable, PEIP_INF_Channel, PEIP_INF_Pollable_Channel
 */



class PEIP_Priority_Channel 
    extends PEIP_Queue_Channel {
    
    protected $priorityHeader = 'PRIORITY';
        
    
    /**
     * @access public
     * @param $capacity 
     * @param $priorityHeader 
     * @return 
     */
    public function __construct($capacity = -1, $priorityHeader = NULL){
        $this->setCapacity((int)$capacity);
        $this->queue = new SplPriorityQueue(); 
        if($priorityHeader){
            $this->priorityHeader = $priorityHeader;
        }
    }   

    
    /**
     * @access protected
     * @param $message 
     * @return 
     */
    protected function doSend(PEIP_INF_Message $message){
        if($this->capacity < 1 || $this->getMessageCount() <= $this->getCapacity()){
            $this->queue->insert($message, $message->getHeader($this->priorityHeader));
        }else{
            throw new Exception('Not implemented yet.');
        }            
    }       
} 