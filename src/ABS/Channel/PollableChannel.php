<?php

namespace PEIP\ABS\Channel;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

    /**
     * PEIP\ABS\Channel\PollableChannel.
     *
     * @author Timo Michna <timomichna/yahoo.de>
     * @extends \PEIP\ABS\Channel\Channel
     * @implements \PEIP\INF\Event\Connectable, \PEIP\INF\Channel\Channel, \PEIP\INF\Channel\PollableChannel
     */
    class PollableChannel extends \PEIP\ABS\Channel\Channel implements \PEIP\INF\Channel\PollableChannel
    {
        protected $messages = [];

    /**
     * @param $message
     *
     * @return
     */
    protected function doSend(\PEIP\INF\Message\Message $message)
    {
        $this->messages[] = $message;
    }

    /**
     * @param $timeout
     *
     * @return
     */
    public function receive($timeout = -1)
    {
        $message = null;
        if ($timeout == 0) {
            $message = $this->getMessage();
        } elseif ($timeout < 0) {
            while (!$message = $this->getMessage()) {
            }
        } else {
            $time = time() + $timeout;
            while (($time > time()) && !$message = $this->getMessage()) {
            }
        }

        return $message;
    }

    /**
     * @return
     */
    protected function getMessage()
    {
        return array_shift($this->messages);
    }

    /**
     * @return
     */
    public function clear()
    {
        $this->messages = [];
    }

    /**
     * @param $selector
     *
     * @return
     */
    public function purge(\PEIP\INF\Selector\MessageSelector $selector)
    {
        foreach ($this->messages as $key => $message) {
            if (!$selector->acceptMessage($message)) {
                unset($this->messages[$key]);
            }
        }

        return $this->messages;
    }
    }
