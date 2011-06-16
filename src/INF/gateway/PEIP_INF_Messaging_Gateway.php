<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_INF_Messaging_Gateway 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage gateway 
 */



interface PEIP_INF_Messaging_Gateway {

    public function setRequestChannel(PEIP_INF_Channel $requestChannel);

    public function setReplyChannel(PEIP_INF_Channel $replyChannel);

    public function send($content);
    
    public function receive();
    
    public function sendAndReceive($content);
    
}