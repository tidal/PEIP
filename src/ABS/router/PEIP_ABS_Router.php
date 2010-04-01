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
     * @access public
     * @param $channelResolver 
     * @param $inputChannel 
     * @return 
     */
    public function __construct(PEIP_INF_Channel_Resolver $channelResolver, PEIP_INF_Channel $inputChannel){
        $this->channelResolver = $channelResolver;
        $this->setInputChannel($inputChannel);  
    }               
            
    
    /**
     * @access public
     * @param $channelResolver 
     * @return 
     */
    public function setChannelResolver(PEIP_INF_Channel_Resolver $channelResolver){
        $this->channelResolver = $channelResolver;
    }
    
    
    /**
     * @access protected
     * @param $message 
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
     * @access protected
     * @param $channel 
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
     * @access protected
     * @param $message 
     * @return 
     */
    abstract protected function selectChannels(PEIP_INF_Message $message);
    

}
