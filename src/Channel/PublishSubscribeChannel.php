<?php

namespace PEIP\Channel;


/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PublishSubscribeChannel 
 * Basic Concrete implementation of a publish-subscribe-channel
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 * @extends \PEIP\ABS\Channel\SubscribableChannel
 * @implements \PEIP\INF\Channel\SubscribableChannel, \PEIP\INF\Channel\Channel, \PEIP\INF\Event\Connectable
 */

use
    \PEIP\Constant\Event,
    \PEIP\Constant\Header;

class PublishSubscribeChannel 
    extends \PEIP\ABS\Channel\SubscribableChannel {
   
    /**
     * Sends a given message on the channel by notifying all subscribers
     * 
     * @event prePublish
     * @event postPublish
     * @access protected
     * @param $message 
     * @return 
     */
    protected function doSend(\PEIP\INF\Message\Message $message){
        $this->doFireEvent(Event::PRE_PUBLISH, array(Header::MESSAGE=>$message));
        $this->getMessageDispatcher()->notify($message);
        $this->doFireEvent(Event::POST_PUBLISH, array(Header::MESSAGE=>$message));
        return true;
    }

}

