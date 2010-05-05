<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_ABS_Router
 * Basic abstract implementation of a message router. 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage router 
 * @extends PEIP_Pipe
 * @implements PEIP_INF_Connectable, PEIP_INF_Subscribable_Channel, PEIP_INF_Channel, PEIP_INF_Handler, PEIP_INF_Message_Builder
 */


abstract class PEIP_ABS_Router 
    extends PEIP_Pipe {

    protected $channelResolver;
   
    /**
     * constructor
     * 
     * @access public
     * @param PEIP_INF_Channel_Resolver $channelResolver channel resolver for the router 
     * @param PEIP_INF_Channel $inputChannel the input channel for the router 
     * @return 
     */
    public function __construct(PEIP_INF_Channel_Resolver $channelResolver, PEIP_INF_Channel $inputChannel){
        $this->channelResolver = $channelResolver;
        $this->setInputChannel($inputChannel);  
    }               
               
    /**
     * Sets the channel resolver for the router
     * 
     * @access public
     * @param PEIP_INF_Channel_Resolver $channelResolver the channel resolver for the router
     * @return 
     */
    public function setChannelResolver(PEIP_INF_Channel_Resolver $channelResolver){
        $this->channelResolver = $channelResolver;
    }
      
    /**
     * Sends given message on all accepted reply-channels
     * 
     * @access protected
     * @param PEIP_INF_Message $message the message to reply with
     * @return 
     */
    protected function doReply(PEIP_INF_Message $message){  
        $ch = $this->selectChannels($message);
        $channels = is_array($ch) ? $ch : array($ch);
        foreach($channels as $channel){
            $this->setOutputChannel($this->resolveChannel($channel));
            $this->replyMessage($message); 
        }
    }   
  
    /**
     * Resolves a channel from name or channel-instance.
     * Returns first argument directly if it is intance of PEIP_INF_Channel.
     * Else resolves channel through registered channel-resolver
     * 
     * @access protected
     * @param mixed $channel channel-name or instance of PEIP_INF_Channel 
     * @return 
     */
    protected function resolveChannel($channel){
        if(!($channel instanceof PEIP_INF_Channel)){
            $channel = $this->channelResolver->resolveChannelName($channel);
            if(!$channel){
                throw new RuntimeException('Could not resolve Channel : '.$channel);
            }
        }
        return $channel;
    }
       
    /**
     * Selects channel(s) to route given message to.
     * 
     * @abstract 
     * @access protected
     * @param PEIP_INF_Message $message message to route
     */
    abstract protected function selectChannels(PEIP_INF_Message $message);
    
}
