<?php

namespace PEIP\Pipe;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * CommandPipe
 * Class to call commands on an arbitrary pipe by passing messages from the input
 * to the 'command' method of the commanded pipe.
 *  
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage pipe 
 * @extends \PEIP\Pipe\EventPipe
 * @implements \PEIP\INF\Event\Listener, \PEIP\INF\Event\Connectable, \PEIP\INF\Channel\SubscribableChannel, \PEIP\INF\Channel\Channel, \PEIP\INF\Handler\Handler, \PEIP\INF\Message\MessageBuilder
 */


class CommandPipe 
    extends \PEIP\Pipe\EventPipe {
   
    /**
     * Does the reply logic. Calls the 'command' method of the registered output-channel
     * with request-message as argument.
     * 
     * @access protected
     * @param $content 
     * @return 
     */
    protected function replyMessage($content){
        $message = $this->ensureMessage($content);      
        $this->getOutputChannel()->command($message);       
    }

}