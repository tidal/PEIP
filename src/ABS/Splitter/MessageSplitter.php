<?php

namespace PEIP\ABS\Splitter;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP\ABS\Splitter\MessageSplitter
 * Abstract base class for message-splitters. 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage splitter 
 * @extends \PEIP\Pipe\Pipe
 * @implements \PEIP\INF\Event\Connectable, \PEIP\INF\Channel\SubscribableChannel, \PEIP\INF\Channel\Channel, \PEIP\INF\Handler\Handler, \PEIP\INF\Message\MessageBuilder
 */


use \PEIP\Pipe\Pipe;

abstract class MessageSplitter 
    extends \PEIP\Pipe\Pipe {
   
    /**
     * constructor
     * 
     * @access public
     * @param \PEIP\INF\Channel\Channel $inputChannel the input-channel
     * @param \PEIP\INF\Channel\Channel $outputChannel the outputs-channel 
     * @return 
     */
    public function __construct(\PEIP\INF\Channel\Channel $inputChannel, \PEIP\INF\Channel\Channel $outputChannel = NULL){
        $this->setInputChannel($inputChannel);
        if(is_object($outputChannel)){
            $this->setOutputChannel($outputChannel);    
        }   
    }           
         
    /**
     * Sends splitted message on output-channel
     * 
     * @access public
     * @param \PEIP\INF\Message\Message $message message to split 
     * @return 
     */
    public function doReply(\PEIP\INF\Message\Message $message){     
        $res = $this->split($message);      
        if(is_array($res)){
            foreach($res as $msg){ 
                $this->replyMessage($msg);
            }
        }else{
            $this->replyMessage($res);
        }
    }
  
    /**
     * Splits a message 
     * 
     * @abstract
     * @access public
     * @param \PEIP\INF\Message\Message $message 
     * @return mixed result of splitting the message - array or arbitrary value
     */
    abstract public function split(\PEIP\INF\Message\Message $message);

}

