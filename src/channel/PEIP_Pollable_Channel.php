<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Pollable_Channel 
 * Basic concete implementation of a pollable channel
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 * @extends PEIP_ABS_Channel
 * @implements PEIP_INF_Connectable, PEIP_INF_Channel, PEIP_INF_Pollable_Channel
 */

class PEIP_Pollable_Channel  
    extends PEIP_ABS_Channel
    implements PEIP_INF_Pollable_Channel {

    const       
        EVENT_PRE_RECEIVE = 'pre_receive',
        EVENT_POST_RECEIVE = 'post_receive',
        HEADER_MESSAGE = 'MESSAGE';
    
    protected 
        $messages = array();
          
    /**
     * Sends a message on the channel.
     * 
     * @access protected
     * @param PEIP_INF_Message $message the message to send
     * @return 
     */
    protected function doSend(PEIP_INF_Message $message){
        $this->messages[] = $message;
        return true;
    }
      
    /**
     * Receives a message from the channel
     * 
     * @event preReceive
     * @event postReceive
     * @access public
     * @param integer $timeout timout for receiving a message 
     * @return 
     */
    public function receive($timeout = 0){
        $this->doFireEvent(self::EVENT_PRE_RECEIVE);
        $message = NULL;
        if($timeout == 0){
            $message = $this->getMessage(); 
        }elseif($timeout < 0){
            while(!$message = $this->getMessage()){
                                
            }
        }else{
            $time = time() + $timeout;
            while(($time > time()) && !$message = $this->getMessage()){
                
            }       
        }
        $this->doFireEvent(
            self::EVENT_PRE_RECEIVE, array(
                self::HEADER_MESSAGE=>$message
            )
        );
        return $message;
    }
   
    /**
     * Returns a message from top of the message stack
     * 
     * @access protected
     * @return PEIP_INF_Message message from top of the message stack
     */
    protected function getMessage(){
        return array_shift($this->messages);
    }
       
    /**
     * Deletes all messages on the message stack.
     * 
     * @access public
     * @return 
     */
    public function clear(){
        $this->messages = array();
    }
        
    /**
     * Removes all messages not accepted by a given message-selector from the message-stack.
     * 
     * @access public
     * @param PEIP_INF_Message_Selector $selector the selector to accept messages 
     * @return array accepted messages
     */
    public function purge(PEIP_INF_Message_Selector $selector){
        foreach($this->messages as $key=>$message){
            if(!$selector->acceptMessage($message)){
                unset($this->messages[$key]);   
            }
        }
        return $this->messages;
    }
           
}