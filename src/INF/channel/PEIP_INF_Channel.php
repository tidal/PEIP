<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_INF_Channel 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 */



interface PEIP_INF_Channel {

    /**
     * Return the name of this channel.
     */
    public function getName();


    /**
     * Send a message, blocking until either the message is accepted or the
     * specified timeout period elapses.
     * 
     * @param message the {@link Message} to send
     * @param timeout the timeout in milliseconds
     * 
     * @return <code>true</code> if the message is sent successfully,
     * <code>false</false> if the specified timeout period elapses or
     * the send is interrupted
     */
    public function send(PEIP_INF_Message $message, $timeout = -1);


}