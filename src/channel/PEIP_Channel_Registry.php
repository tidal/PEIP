<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Channel_Registry 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 * @implements PEIP_INF_Channel_Resolver
 */


class PEIP_Channel_Registry 
    implements PEIP_INF_Channel_Resolver {

    protected $channels = array();

    protected static $instance;
    
    /**
     * @access public
     * @param $name 
     * @return 
     */
    public function getInstance(){
        return self::$instance ? self::$instance : self::$instance = new PEIP_Channel_Registry;
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
