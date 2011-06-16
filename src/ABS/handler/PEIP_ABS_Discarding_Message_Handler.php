<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_ABS_Discarding_Message_Handler 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage handler 
 * @extends PEIP_ABS_Reply_Producing_Message_Handler
 * @implements PEIP_INF_Message_Builder, PEIP_INF_Handler
 */


abstract class PEIP_ABS_Discarding_Message_Handler 
    extends PEIP_ABS_Reply_Producing_Message_Handler {

    protected $discardChannel;
        
    
    /**
     * @access public
     * @param $discardChannel 
     * @return 
     */
    public function setDiscardChannel(PEIP_INF_Channel $discardChannel){
        $this->discardChannel = $discardChannel;    
    }   

    
    /**
     * @access public
     * @return 
     */
    public function getDiscardChannel(){
        return $this->discardChannel;   
    }   

    
    /**
     * @access protected
     * @param $message 
     * @return 
     */
    protected function discardMessage(PEIP_INF_Message $message){
        if(isset($this->discardChannel)){
            $this->discardChannel->send($message);
        }
    }

}

