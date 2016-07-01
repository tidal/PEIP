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
 * MessageChannel 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 * @implements \PEIP\INF\Channel\Channel
 */



class MessageChannel implements \PEIP\INF\Channel\Channel {

    
    /**
     * @access public
     * @return 
     */
    public function getName(){
    
    }


    
    /**
     * @access public
     * @param $message 
     * @param $timeout 
     * @return 
     */
    public function send(\PEIP\INF\Message\Message $message, $timeout = -1){
        
    }



}