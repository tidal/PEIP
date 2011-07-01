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
 * ContentClassSelector 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage selector 
 * @implements \PEIP\INF\Selector\MessageSelector
 */



class ContentClassSelector
    implements \PEIP\INF\Selector\MessageSelector {
    
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
    public function acceptMessage(\PEIP\INF\Message\Message $message){
        return $message->getContent() instanceof $this->className;
    }           
    
}

