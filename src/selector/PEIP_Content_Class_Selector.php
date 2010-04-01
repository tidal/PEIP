<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Content_Class_Selector 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage selector 
 * @implements PEIP_INF_Message_Selector
 */


class PEIP_Content_Class_Selector
    implements PEIP_INF_Message_Selector {
    
    protected 
        $className;
        
    
    /**
     * @access public
     * @param $className 
     * @return 
     */
    public function __construct($className){
        $this->className = $className;
    }       
            
    
    /**
     * @access public
     * @param $message 
     * @return 
     */
    public function acceptMessage(PEIP_INF_Message $message){
        return $message->getContent() instanceof $className;
    }           
    
}

