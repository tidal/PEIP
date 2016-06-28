<?php

namespace PEIP\ABS\Channel;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP\ABS\Channel\PollableChannel 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 * @extends \PEIP\ABS\Channel\Channel
 * @implements \PEIP\INF\Event\Connectable, \PEIP\INF\Channel\Channel, \PEIP\INF\Channel\PollableChannel
 */


 class PollableChannel     
    extends \PEIP\ABS\Channel\Channel
    implements \PEIP\INF\Channel\PollableChannel {

    protected 
        $messages = array();
        
    
    /**
     * @access protected
     * @param $message 
     * @return 
     */
    protected function doSend(\PEIP\INF\Message\Message $message){
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
    public function purge(\PEIP\INF\Selector\MessageSelector $selector){
        foreach($this->messages as $key=>$message){
            if(!$selector->acceptMessage($message)){
                unset($this->messages[$key]);   
            }
        }
        return $this->messages;
    }
        
    
}
