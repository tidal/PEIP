<?php

namespace PEIP\INF\Gateway;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Gateway\MessagingGateway 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage gateway 
 */




interface MessagingGateway {

    public function setRequestChannel(\PEIP\INF\Channel\Channel $requestChannel);

    public function setReplyChannel(\PEIP\INF\Channel\Channel $replyChannel);

    public function send($content);
    
    public function receive();
    
    public function sendAndReceive($content);
    
}