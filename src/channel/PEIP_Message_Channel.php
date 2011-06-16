<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Message_Channel 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 * @implements PEIP_INF_Channel
 */


class PEIP_Message_Channel implements PEIP_INF_Channel {

    
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
    public function send(PEIP_INF_Message $message, $timeout = -1){
        
    }



}