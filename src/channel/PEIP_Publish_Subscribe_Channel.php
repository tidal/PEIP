<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Publish_Subscribe_Channel 
 * Basic Concrete implementation of a publish-subscribe-channel
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 * @extends PEIP_ABS_Subscribable_Channel
 * @implements PEIP_INF_Subscribable_Channel, PEIP_INF_Channel, PEIP_INF_Connectable
 */


class PEIP_Publish_Subscribe_Channel 
    extends PEIP_ABS_Subscribable_Channel {
   
    /**
     * Sends a given message on the channel by notifying all subscribers
     * 
     * @event prePublish
     * @event postPublish
     * @access protected
     * @param $message 
     * @return 
     */
    protected function doSend(PEIP_INF_Message $message){
        $this->doFireEvent('prePublish', array('MESSAGE'=>$message));
        $this->getMessageDispatcher()->notify($message);
        $this->doFireEvent('postPublish', array('MESSAGE'=>$message));
        return true;
    }

}

