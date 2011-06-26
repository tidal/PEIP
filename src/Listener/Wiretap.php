<?php

namespace PEIP\Listener;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Wiretap 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage listener 
 * @extends \PEIP\Pipe\FixedEventPipe
 * @implements \PEIP\INF\Message\MessageBuilder, \PEIP\INF\Handler\Handler, \PEIP\INF\Channel\Channel, \PEIP\INF\Channel\SubscribableChannel, \PEIP\INF\Event\Connectable, \PEIP\INF\Event\Listener
 */


use \PEIP\Pipe\FixedEventPipe;

class Wiretap 
    extends \PEIP\Pipe\FixedEventPipe {

    
    /**
     * @access public
     * @param $inputChannel 
     * @param $outputChannel 
     * @return 
     */
    public function __construct(\PEIP\INF\Channel\Channel $inputChannel, \PEIP\INF\Channel\Channel $outputChannel = NULL){
        $this->setEventName('preSend');
        $this->setInputChannel($inputChannel);
        if(is_object($outputChannel)){
            $this->setOutputChannel($outputChannel);
        }           
    }           
        
    
    /**
     * @access protected
     * @param $message 
     * @return 
     */
    protected function doReply(\PEIP\INF\Message\Message $message){
        $this->replyMessage($message->getHeader('MESSAGE'));
    }
    
} 
