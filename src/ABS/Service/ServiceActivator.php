<?php

namespace PEIP\ABS\Service;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP\ABS\Service\ServiceActivator 
 * Abstract base class for all service activators
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage service 
 * @extends \PEIP\Pipe\Pipe
 * @implements \PEIP\INF\Event\Connectable, \PEIP\INF\Channel\SubscribableChannel, \PEIP\INF\Channel\Channel, \PEIP\INF\Handler\Handler, \PEIP\INF\Message\MessageBuilder
 */

use \PEIP\Constant\Header;
use \PEIP\Pipe\Pipe;

abstract class ServiceActivator
    extends \PEIP\Pipe\Pipe {
        
    protected 
        $serviceCallable;
         
    /**
     * Handles the reply logic.
     * Delegates calling of service to method 'callService'.
     * Replies on message's reply-channel or registered output-channel if set.
     * 
     * @access protected
     * @param \PEIP\INF\Message\Message $message message to handle/reply for
     * @return 
     */
    public function doReply(\PEIP\INF\Message\Message $message){
        $res = $this->callService($message);
        $replyChannel = $this->resolveReplyChannel($message);
        $replyChannel = $replyChannel instanceof \PEIP\INF\Channel\Channel
            ? $replyChannel
            : $this->outputChannel;    
        $this->replyMessage($res, $replyChannel);

    }  

    /**
     * Calls a method on a service (registered as a callable) with 
     * content/payload of given message as argument.
     * 
     * @access protected
     * @param \PEIP\INF\Message\Message $message message to call the service with it�s content/payload
     * @return mixed result of calling the registered service callable with message content/payload
     */
    protected function callService(\PEIP\INF\Message\Message $message){
        $res = NULL;
        if(is_callable($this->serviceCallable)){
            $res = call_user_func($this->serviceCallable, $message->getContent());
        }else{
            if(is_object($this->serviceCallable) && method_exists($this->serviceCallable, 'handle')){
                $res = $this->serviceCallable->handle($message->getContent());
            }
        }    
        return $res;
    }   
} 