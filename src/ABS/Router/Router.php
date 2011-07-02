<?php

namespace PEIP\ABS\Router;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP\ABS\Router\Router
 * Basic abstract implementation of a message router. 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage router 
 * @extends \PEIP\Pipe\Pipe
 * @implements \PEIP\INF\Event\Connectable, \PEIP\INF\Channel\SubscribableChannel, \PEIP\INF\Channel\Channel, \PEIP\INF\Handler\Handler, \PEIP\INF\Message\MessageBuilder
 */


use \PEIP\Pipe\Pipe;

abstract class Router 
    extends \PEIP\Pipe\Pipe {

    
    const 
        EVENT_PRE_RESOLVE = 'pre_resolve',
        EVENT_POST_RESOLVE = 'post_resolve',
        EVENT_ERR_RESOLVE = 'err_resolve',
        HEADER_CHANNEL  = 'CHANNEL',
        HEADER_CHANNEL_NAME = 'CHANNEL_NAME',
        HEADER_CHANNEL_RESOLVER = 'HEADER_CHANNEL_RESOLVER';

    protected $channelResolver;
   
    /**
     * constructor
     * 
     * @access public
     * @param \PEIP\INF\Channel\Channel_Resolver $channelResolver channel resolver for the router 
     * @param \PEIP\INF\Channel\Channel $inputChannel the input channel for the router 
     * @return 
     */
    public function __construct(\PEIP\INF\Channel\Channel_Resolver $channelResolver, \PEIP\INF\Channel\Channel $inputChannel){
        $this->channelResolver = $channelResolver;
        $this->setInputChannel($inputChannel);  
    }               
               
    /**
     * Sets the channel resolver for the router
     * 
     * @access public
     * @param \PEIP\INF\Channel\Channel_Resolver $channelResolver the channel resolver for the router
     * @return 
     */
    public function setChannelResolver(\PEIP\INF\Channel\Channel_Resolver $channelResolver){
        $this->doFireEvent(self::EVENT_CHANNEL_RESOLVER_SET, array(self::HEADER_CHANNEL_RESOLVER=>$channelResolver));
        $this->channelResolver = $channelResolver;
        $this->doFireEvent(self::EVENT_CHANNEL_RESOLVER_SET, array(self::HEADER_CHANNEL_RESOLVER=>$channelResolver));
    }
      
    /**
     * Sends given message on all accepted reply-channels
     * 
     * @access protected
     * @param \PEIP\INF\Message\Message $message the message to reply with
     * @return 
     */
    protected function doReply(\PEIP\INF\Message\Message $message){  
        $channels = (array)$this->selectChannels($message);
        foreach($channels as $channel){
            $this->setOutputChannel($this->resolveChannel($channel));
            $this->replyMessage($message); 
        }
    }   
  
    /**
     * Resolves a channel from name or channel-instance.
     * Returns first argument directly if it is intance of \PEIP\INF\Channel\Channel.
     * Else resolves channel through registered channel-resolver
     * 
     * @access protected
     * @param mixed $channel channel-name or instance of \PEIP\INF\Channel\Channel 
     * @return 
     */
    protected function resolveChannel($channel){
        $this->doFireEvent(self::EVENT_PRE_RESOLVE, array(self::HEADER_CHANNEL=>$channel));
        if(!($channel instanceof \PEIP\INF\Channel\Channel)){
            $channelName = $channel;
            $channel = $this->channelResolver->resolveChannelName($channelName);
            if(!$channel){
                $this->doFireEvent(self::EVENT_ERR_RESOLVE, array(self::HEADER_CHANNEL_NAME=>$channelName));
                throw new \RuntimeException('Could not resolve Channel : '.$channelName);
            }
        }
        $this->doFireEvent(self::EVENT_POST_RESOLVE, array(self::HEADER_CHANNEL=>$channel));
        return $channel;
    }
       
    /**
     * Selects channel(s) to route given message to.
     * 
     * @abstract 
     * @access protected
     * @param \PEIP\INF\Message\Message $message message to route
     */
    abstract protected function selectChannels(\PEIP\INF\Message\Message $message);
    
}
