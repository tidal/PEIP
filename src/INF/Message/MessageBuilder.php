<?php

namespace PEIP\INF\Message;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Message\MessageBuilder.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 */
interface MessageBuilder
{
    public function setMessageClass($messageClass);

    public function getMessageClass();
}
