<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_ABS_Message_Handler 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage handler 
 * @implements PEIP_INF_Handler
 */


abstract class PEIP_ABS_Message_Handler 
    implements PEIP_INF_Handler {
    
    protected 
        $inputChannel;
        
        
    
    /**
     * @access public
     * @param $message 
     * @return 
     */
    public function handle($message){
        return $this->doHandle($message);
    }

    
    /**
     * @access public
     * @param $inputChannel 
     * @return 
     */
    public function setInputChannel(PEIP_INF_Channel $inputChannel){
        $this->doSetInputChannel($inputChannel);
        return $this;
    }

    
    /**
     * @access protected
     * @param $inputChannel 
     * @return 
     */
    protected function doSetInputChannel(PEIP_INF_Channel $inputChannel){
        $this->inputChannel = $inputChannel;    
        $messageHandler = $this;
        if($inputChannel instanceof PEIP_INF_Subscribable_Channel){
            $getMessage = function ($object){
                return $object;
            };  
            $linkChannel = function($handler) use ($messageHandler){
                $messageHandler->getInputChannel()->subscribe($handler);    
            };              
        }else{          
            $getMessage = function ($object){
                return $object->getContent()->receive();
            };  
            $linkChannel = function($handler) use ($messageHandler){
                $messageHandler->getInputChannel()->connect('postSend', $handler);  
            };  
        }   
        $handling = function($object) use ($messageHandler, $getMessage){
            $message = $getMessage($object);
            if(!is_object($message)){ 
                throw new Exception('Could not get Message from Channel');
            }               
            $messageHandler->handle($message);          
        };          
        $handler = new PEIP_Callable_Message_Handler($handling);
        $linkChannel($handler); 
    }
    
    
    
    /**
     * @access public
     * @return 
     */
    public function getInputChannel(){
        return $this->inputChannel;
    }   
    
    
    /**
     * @access protected
     * @param $message 
     * @return 
     */
    abstract protected function doHandle(PEIP_INF_Message $message);
    
}

