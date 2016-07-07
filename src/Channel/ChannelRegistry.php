<?php

namespace PEIP\Channel;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * ChannelRegistry.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @implements \PEIP\INF\Channel\ChannelResolver
 */
class ChannelRegistry implements \PEIP\INF\Channel\ChannelResolver
{
    protected $channels = [];

    protected static $instance;

    /**
     * @param $name
     *
     * @return
     */
    public static function getInstance()
    {
        return self::$instance ? self::$instance : self::$instance = new self();
    }

    /**
     * @param $channel
     *
     * @return
     */
    public function register($channel)
    {
        $this->channels[$channel->getName()] = $channel;
    }

    /**
     * @param $name
     *
     * @return
     */
    public function get($name)
    {
        return $this->channels[$name];
    }

    /**
     * @param $channelName
     *
     * @return
     */
    public function resolveChannelName($channelName)
    {
        return $this->get($channelName);
    }
}
