<?php

namespace PEIP\Channel;

namespace PEIP\Channel;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PriorityChannel 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 * @extends \PEIP\Channel\QueueChannel
 * @implements \PEIP\INF\Event\Connectable, \PEIP\INF\Channel\Channel, \PEIP\INF\Channel\PollableChannel
 */

use \SplPriorityQueue;


class PriorityChannel 
    extends \PEIP\Channel\QueueChannel {
    
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
    protected function doSend(\PEIP\INF\Message\Message $message){
        if($this->capacity < 1 || $this->getMessageCount() <= $this->getCapacity()){
            $this->queue->insert($message, $message->getHeader($this->priorityHeader));
        }else{
            throw new \Exception('Not implemented yet.');
        }            
    }       
} 