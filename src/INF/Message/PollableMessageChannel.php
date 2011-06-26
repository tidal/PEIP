<?php

namespace PEIP\INF\Message;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Message\PollableMessageChannel 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage message 
 * @implements \PEIP\INF\Message\MessageChannel, \PEIP\INF\Message\MessageSender
 */




interface PollableMessageChannel extends \PEIP\INF\Message\MessageChannel {

    public function receive($timeout = NULL);

    public function clear();
    
    public function purge(\PEIP\INF\Selector\MessageSelector $selector);
    

}