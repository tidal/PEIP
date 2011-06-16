<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Content_Type_Selector 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage selector 
 * @implements PEIP_INF_Message_Selector
 */


class PEIP_Content_Type_Selector
    implements PEIP_INF_Message_Selector {
            
    protected 
        $type;
        
    protected static 
        $types = array(
            'string' => 'is_string',
            'int' => 'is_int',
            'float' => 'is_float',
            'numeric' => 'is_numeric',
            'bool' => 'is_bool',
            'boolean' => 'is_bool',
            'array' => 'is_array',
            'scalar' => 'is_scalar',
            'object' => 'is_object',
            'resource' => 'is_resource'
        );
        
    
    /**
     * @access public
     * @param $type 
     * @return 
     */
    public function __construct($type){
        $this->type = $type;
    }       
            
    
    /**
     * @access public
     * @param $message 
     * @return 
     */
    public function acceptMessage(PEIP_INF_Message $message){
        return call_user_func(self::$types[$this->type], $message->getContent());
    }           
    
} 

