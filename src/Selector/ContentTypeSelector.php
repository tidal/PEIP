<?php

namespace PEIP\Selector;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * ContentTypeSelector 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage selector 
 * @implements \PEIP\INF\Selector\MessageSelector
 */



class ContentTypeSelector
    implements \PEIP\INF\Selector\MessageSelector {
            
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
        if(isset(self::$types[$type])){
            $this->type = $type;
        }else{
            throw new \InvalidArgumentException('Type is not supported');
        }
    }       
            
    
    /**
     * @access public
     * @param $message 
     * @return 
     */
    public function acceptMessage(\PEIP\INF\Message\Message $message){
        return call_user_func(self::$types[$this->type], $message->getContent());
    }           
    
} 

