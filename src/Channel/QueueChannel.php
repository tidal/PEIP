<?php

namespace PEIP\Channel;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use SplQueue;

/**
 * QueueChannel.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @extends \PEIP\ABS\Channel\PollableChannel
 * @implements \PEIP\INF\Channel\PollableChannel, \PEIP\INF\Channel\Channel, \PEIP\INF\Event\Connectable
 */
class QueueChannel extends \PEIP\ABS\Channel\PollableChannel
{
    protected $capacity,
        $queue;

    /**
     * @param $capacity
     *
     * @return
     */
    public function __construct($capacity = -1)
    {
        $this->setCapacity((int) $capacity);
        $this->queue = new SplQueue();
    }

    /**
     * @return
     */
    public function getMessageCount()
    {
        return count($this->messages);
    }

    /**
     * @return
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @param $capacity
     *
     * @return
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

    /**
     * @param $message
     *
     * @return
     */
    protected function doSend(\PEIP\INF\Message\Message $message)
    {
        if ($this->capacity < 1 || $this->getMessageCount() <= $this->getCapacity()) {
            $this->queue->enqueque($message);
        } else {
            throw new \Exception('Not implemented yet.');
        }
    }
}
