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
 * ChannelRegistry 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 * @implements \PEIP\INF\Channel\ChannelResolver
 */



class ChannelRegistry 
    implements \PEIP\INF\Channel\ChannelResolver {

    protected $channels = array();

    protected static $instance;
    
    /**
     * @access public
     * @param $name 
     * @return 
     */
    public static function getInstance(){
        return self::$instance ? self::$instance : self::$instance = new ChannelRegistry;
    }
    
    
    /**
     * @access public
     * @param $channel 
     * @return 
     */
    public function register($channel){
        $this->channels[$channel->getName()] = $channel;
    }

    
    
    
    /**
     * @access public
     * @param $name 
     * @return 
     */
    public function get($name){
        return $this->channels[$name];
    }

    
    /**
     * @access public
     * @param $channelName 
     * @return 
     */
    public function resolveChannelName($channelName){
        return $this->get($channelName);
    }   
    
}
