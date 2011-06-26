<?php

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP\ABS\Transformer\ContentTransformer
 * Abstract base class for content-transformers. 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage transformer 
 * @extends PEIP\Pipe\Pipe
 * @implements \PEIP\INF\Transformer\Transformer, \PEIP\INF\Event\Connectable, \PEIP\INF\Channel\SubscribableChannel, \PEIP\INF\Channel\Channel, \PEIP\INF\Handler\Handler, \PEIP\INF\Message\MessageBuilder
 */



namespace PEIP\ABS\Transformer;

abstract class ContentTransformer 
    extends \PEIP\ABS\Transformer\Transformer {
  
    /**
     * Transforms a message 
     * 
     * @abstract
     * @access protected
     * @param \PEIP\INF\Message\Message $message 
     * @return mixed result of transforming the message payload/content 
     */
    protected function doTransform(\PEIP\INF\Message\Message $message){
        return $this->transformContent($message->getContent());    
    }

    /**
     * Transforms message-content 
     * 
     * @abstract
     * @access protected
     * @param mixed $content content/payload of message 
     * @return mixed result of transforming the message payload/content 
     */
    abstract protected function transformContent($content); 

}
