<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Simple_Event_Pipe 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage pipe 
 * @extends PEIP_Event_Pipe
 * @implements PEIP_INF_Listener, PEIP_INF_Connectable, PEIP_INF_Subscribable_Channel, PEIP_INF_Channel, PEIP_INF_Handler, PEIP_INF_Message_Builder
 */


class PEIP_Simple_Event_Pipe 
    extends PEIP_Event_Pipe {

    
    /**
     * @access public
     * @param $eventName 
     * @param $inputChannel 
     * @param $outputChannel 
     * @return 
     */
    public function __construct($eventName, PEIP_INF_Channel $inputChannel, PEIP_INF_Channel $outputChannel){
        $this->setEventName($eventName);
        $this->setInputChannel($inputChannel);
        $this->setOutputChannel($outputChannel);        
    }       
        
        
}

