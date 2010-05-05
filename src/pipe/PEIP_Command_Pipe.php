<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Command_Pipe
 * Class to call commands on an arbitrary pipe by passing messages from the input
 * to the 'command' method of the commanded pipe.
 *  
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage pipe 
 * @extends PEIP_Event_Pipe
 * @implements PEIP_INF_Listener, PEIP_INF_Connectable, PEIP_INF_Subscribable_Channel, PEIP_INF_Channel, PEIP_INF_Handler, PEIP_INF_Message_Builder
 */

class PEIP_Command_Pipe 
    extends PEIP_Event_Pipe {
   
    /**
     * Does the reply logic. Calls the 'command' method of the registered output-channel
     * with request-message as argument.
     * 
     * @access protected
     * @param $content 
     * @return 
     */
    protected function replyMessage($content){
        $message = $this->ensureMessage($content);      
        $this->getOutputChannel()->command($message);       
    }

}