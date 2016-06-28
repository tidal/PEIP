<?php

namespace PEIP\ABS\Transformer;

namespace PEIP\ABS\Transformer;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP\ABS\Transformer\Transformer
 * Abstract base class for transformers. 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage transformer 
 * @extends \PEIP\Pipe\Pipe
 * @implements \PEIP\INF\Transformer\Transformer, \PEIP\INF\Event\Connectable, \PEIP\INF\Channel\SubscribableChannel, \PEIP\INF\Channel\Channel, \PEIP\INF\Handler\Handler, \PEIP\INF\Message\MessageBuilder
 */


use \PEIP\Pipe\Pipe;

abstract class Transformer 
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
     * Sends transformed message on output-channel
     * 
     * @access public
     * @param \PEIP\INF\Message\Message $message message to transform content 
     * @return 
     */
    public function doReply(\PEIP\INF\Message\Message $message){     
        $this->replyMessage($this->transform($message));
    }
  
    /**
     * Transforms a message 
     * 
     * @access public
     * @param \PEIP\INF\Message\Message $message 
     * @return mixed result of transforming the message 
     */
    public function transform(\PEIP\INF\Message\Message $message){
        return $this->doTransform($message);
    }


    /**
     * Transforms a message 
     * 
     * @abstract
     * @access protected
     * @param \PEIP\INF\Message\Message $message 
     * @return mixed result of transforming the message 
     */
    abstract protected function doTransform(\PEIP\INF\Message\Message $message);

}

