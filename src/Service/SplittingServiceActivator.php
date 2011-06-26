<?php

namespace PEIP\Service;
/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\Service\ServiceActivator 
 * 
 * Calls the service method with the content of the Message (array) as arguments
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage service 
 * @extends PEIP\ABS\Service\ServiceActivator
 * @implements \PEIP\INF\Message\MessageBuilder, \PEIP\INF\Handler\Handler, \PEIP\INF\Channel\Channel, \PEIP\INF\Channel\SubscribableChannel, \PEIP\INF\Event\Connectable
 */


class SplittingServiceActivator
    extends \PEIP\Service\ServiceActivator {
              
    /**
     * Calls a method on a service (registered as a callable) with 
     * content/payload (array) of given message as arguments.
     * 
     * @access protected
     * @param \PEIP\INF\Message\Message $message message to call the service with it´s content/payload
     * @return mixed result of calling the registered service callable with message content/payload
     */
    public function callService(\PEIP\INF\Message\Message $message){
        if(is_callable($this->serviceCallable)){
            $res = call_user_func_array($this->serviceCallable, $message->getContent());
        }elseif(is_object($this->serviceCallable) && method_exists($this->serviceCallable, 'handle')){
            $res = call_user_func_array(array($this->serviceCallable, 'handle'), $message->getContent());               
        }
        return $res;
    } 
           
}
