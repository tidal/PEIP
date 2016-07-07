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
 * PEIP\ABS\Channel\Channel.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @implements \PEIP\INF\Channel\Channel, \PEIP\INF\Event\Connectable
 */
abstract class Channel extends \PEIP\ABS\Base\Connectable implements
        \PEIP\INF\Channel\Channel,
        \PEIP\INF\Event\Connectable
{
    protected $name;

    /**
     * @param $name
     *
     * @return
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string the channel�s name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param \PEIP\INF\Message\Message $message
     * @param int                       $timeout
     *
     * @return
     */
    public function send(\PEIP\INF\Message\Message $message, $timeout = -1)
    {
        $this->doFireEvent('preSend', ['MESSAGE' => $message]);
        $sent = $this->doSend($message);
        $this->doFireEvent('postSend', [
            'MESSAGE' => $message,
            'SENT'    => $sent,
            'TIMEOUT' => $timeout,
        ]);
    }

    /**
     * @param \PEIP\INF\Message\Message $message
     *
     * @return
     */
    abstract protected function doSend(\PEIP\INF\Message\Message $message);
}
