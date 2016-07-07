<?php

namespace PEIP\ABS\Handler;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP\ABS\Handler\DiscardingMessageHandler.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @extends \PEIP\ABS\Handler\ReplyProducingMessageHandler
 * @implements \PEIP\INF\Message\MessageBuilder, \PEIP\INF\Handler\Handler
 */
abstract class DiscardingMessageHandler extends \PEIP\ABS\Handler\ReplyProducingMessageHandler
{
    protected $discardChannel;

    /**
     * @param $discardChannel
     *
     * @return
     */
    public function setDiscardChannel(\PEIP\INF\Channel\Channel $discardChannel)
    {
        $this->discardChannel = $discardChannel;
    }

    /**
     * @return
     */
    public function getDiscardChannel()
    {
        return $this->discardChannel;
    }

    /**
     * @param $message
     *
     * @return
     */
    protected function discardMessage(\PEIP\INF\Message\Message $message)
    {
        if (isset($this->discardChannel)) {
            $this->discardChannel->send($message);
        }
    }
}
