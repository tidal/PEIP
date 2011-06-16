<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_INF_Service_Activator 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage service 
 * @implements PEIP_INF_Message_Handler, PEIP_INF_Handler
 */


interface PEIP_INF_Service_Activator 
    extends PEIP_INF_Message_Handler {
    
    public function setInputChannel(PEIP_INF_Channel $inputChannel);
    
    public function setOutputChannel(PEIP_INF_Channel $outputChannel);  
    
}
