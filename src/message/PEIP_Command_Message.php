<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Command_Message 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage message 
 * @extends PEIP_Generic_Message
 * @implements PEIP_INF_Buildable, PEIP_INF_Message, PEIP_INF_Container, PEIP_INF_Command
 */



class PEIP_Command_Message 
    extends PEIP_Generic_Message 
    implements PEIP_INF_Command {

        
    
    /**
     * @access public
     * @param $content 
     * @param $headers 
     * @return 
     */
    public function __construct($content, ArrayAccess $headers = NULL){
        if(!($content instanceof PEIP_INF_Command) && !is_callable($content)){
            throw new BadArgumentException('Argument 1 for PEIP_Command_Message::__construct must be callable or implment PEIP_INF_Command');
        }
        
        
        parent::__construct($content, $headers);    
    }

    
    /**
     * @access public
     * @return 
     */
    public function execute(){
        if(is_callable($this->getContent())){
            return call_user_func($this->getContent());
        }else{
            return $this->getContent()->execute();
        }
    }

}