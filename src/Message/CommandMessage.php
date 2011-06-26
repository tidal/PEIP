<?php

namespace PEIP\Message;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * CommandMessage 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage message 
 * @extends \PEIP\Message\GenericMessage
 * @implements \PEIP\INF\Base\Buildable, \PEIP\INF\Message\Message, \PEIP\INF\Base\Container, \PEIP\INF\Command\Command
 */




class CommandMessage 
    extends \PEIP\Message\GenericMessage 
    implements \PEIP\INF\Command\Command {

        
    
    /**
     * @access public
     * @param $content 
     * @param $headers 
     * @return 
     */
    public function __construct($content, ArrayAccess $headers = NULL){
        if(!($content instanceof \PEIP\INF\Command\Command) && !is_callable($content)){
            throw new \BadArgumentException('Argument 1 for CommandMessage::__construct must be callable or implment \PEIP\INF\Command\Command');
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