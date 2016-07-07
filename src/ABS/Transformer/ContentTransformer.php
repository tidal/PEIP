<?php

namespace PEIP\ABS\Transformer;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP\ABS\Transformer\ContentTransformer
 * Abstract base class for content-transformers.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @extends PEIP\Pipe\Pipe
 * @implements \PEIP\INF\Transformer\Transformer, \PEIP\INF\Event\Connectable, \PEIP\INF\Channel\SubscribableChannel, \PEIP\INF\Channel\Channel, \PEIP\INF\Handler\Handler, \PEIP\INF\Message\MessageBuilder
 */
abstract class ContentTransformer extends \PEIP\ABS\Transformer\Transformer
{
    /**
     * Transforms a message.
     *
     * @abstract
     *
     * @param \PEIP\INF\Message\Message $message
     *
     * @return mixed result of transforming the message payload/content
     */
    protected function doTransform(\PEIP\INF\Message\Message $message)
    {
        return $this->transformContent($message->getContent());
    }

    /**
     * Transforms message-content.
     *
     * @abstract
     *
     * @param mixed $content content/payload of message
     *
     * @return mixed result of transforming the message payload/content
     */
    abstract protected function transformContent($content);
}
