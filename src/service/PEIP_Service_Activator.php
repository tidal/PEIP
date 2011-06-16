<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Service_Activator 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage service 
 * @extends PEIP_ABS_Service_Activator
 * @implements PEIP_INF_Message_Builder, PEIP_INF_Handler, PEIP_INF_Channel, PEIP_INF_Subscribable_Channel, PEIP_INF_Connectable
 */


class PEIP_Service_Activator
    extends PEIP_ABS_Service_Activator {
            
    
    /**
     * @access public
     * @param $serviceCallable 
     * @param $inputChannel 
     * @param $outputChannel 
     * @return 
     */
    public function __construct($serviceCallable, PEIP_INF_Channel $inputChannel = NULL, PEIP_INF_Channel $outputChannel = NULL){
        $this->serviceCallable = $serviceCallable;
        if(is_object($inputChannel)){
            $this->setInputChannel($inputChannel);
        }
        if(is_object($outputChannel)){
            $this->setOutputChannel($outputChannel);    
        }   
    }       


}
