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
 * \PEIP\INF\Message\MessageChannel 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage message 
 * @implements \PEIP\INF\Message\MessageSender
 */




interface MessageChannel extends \PEIP\INF\Message\MessageSender {

    public function getName();

}