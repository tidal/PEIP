<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_ABS_Pollable_Channel 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 * @extends PEIP_ABS_Channel
 * @implements PEIP_INF_Connectable, PEIP_INF_Channel, PEIP_INF_Pollable_Channel
 */


class PEIP_ABS_Pollable_Channel     
    extends PEIP_ABS_Channel
    implements PEIP_INF_Pollable_Channel {

    protected 
        $messages = array();
        
    
    /**
     * @access protected
     * @param $message 
     * @return 
     */
    protected function doSend(PEIP_INF_Message $message){
        $this->messages[] = $message;        
    }
    
    
    /**
     * @access public
     * @param $timeout 
     * @return 
     */
    public function receive($timeout = -1){
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
        return $message;
    }

    
    /**
     * @access protected
     * @return 
     */
    protected function getMessage(){
        return array_shift($this->messages);
    }
    
    
    /**
     * @access public
     * @return 
     */
    public function clear(){
        $this->messages = array();
    }
    
    
    /**
     * @access public
     * @param $selector 
     * @return 
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
