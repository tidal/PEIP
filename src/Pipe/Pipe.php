<?php

namespace PEIP\Pipe;

namespace PEIP\Pipe;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * Pipe
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP
 * @subpackage pipe
 * @extends \PEIP\ABS\Handler\ReplyProducingMessageHandler
 * @implements \PEIP\INF\Message\MessageBuilder, \PEIP\INF\Handler\Handler, \PEIP\INF\Channel\Channel, \PEIP\INF\Channel\SubscribableChannel, \PEIP\INF\Event\Connectable
 */

use PEIP\Util\Test;

class Pipe extends \PEIP\ABS\Handler\ReplyProducingMessageHandler implements
        \PEIP\INF\Channel\Channel,
        \PEIP\INF\Channel\SubscribableChannel,
        \PEIP\INF\Event\Connectable,
        \PEIP\INF\Message\MessageBuilder
{
    const
        DEFAULT_CLASS_MESSAGE_DISPATCHER = 'PEIP\Dispatcher\Dispatcher',
        DEFAULT_EVENT_CLASS = 'PEIP\Event\Event',
        EVENT_PRE_PUBLISH = 'prePublish',
        EVENT_POST_PUBLISH = 'postPublish',
        EVENT_SUBSCRIBE = 'subscribe',
        EVENT_UNSUBSCRIBE = 'unsubscribe',
        EVENT_PRE_COMMAND = 'preCommand',
        EVENT_POST_COMMAND = 'postCommand',
        EVENT_SET_MESSAGE_DISPATCHER = 'setMessageDispatcher',
        EVENT_SET_EVENT_DISPATCHER = 'setEventDispatcher',
        HEADER_MESSAGE = 'MESSAGE',
        HEADER_SUBSCRIBER = 'SUBSCRIBER';

    protected $eventDispatcher,
        $messageDispatcher,
        $name,
        $commands = [];

    /**
     * @param $name
     *
     * @return
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $message
     * @param $timeout
     *
     * @return
     */
    public function send(\PEIP\INF\Message\Message $message, $timeout = -1)
    {
        return $this->handle($message);
    }

    /**
     * @param $message
     *
     * @return
     */
    protected function doSend(\PEIP\INF\Message\Message $message)
    {
        $this->doFireEvent(self::EVENT_PRE_PUBLISH, [self::HEADER_MESSAGE => $message]);
        $this->getMessageDispatcher()->notify($message);
        $this->doFireEvent(self::EVENT_POST_PUBLISH, [self::HEADER_MESSAGE => $message]);

        return true;
    }

    /**
     * @param $content
     *
     * @return
     */
    protected function replyMessage($message)
    {
        $message = $this->ensureMessage($message);
        //if(\PEIP\Util\Test::assertMessage($message)){
            if ($this->getOutputChannel()) {
                $this->getOutputChannel()->send($message);
            } else {
                $this->doSend($message);
            }
        //}
    }

    /**
     * @param $message
     *
     * @return
     */
    protected function doReply(\PEIP\INF\Message\Message $message)
    {
        $this->replyMessage($message);
    }

    /**
     * @param $handler
     *
     * @return
     */
    public function subscribe($handler)
    {
        Test::ensureHandler($handler);
        $this->getMessageDispatcher()->connect($handler);
        $this->doFireEvent(self::EVENT_SUBSCRIBE, [self::HEADER_SUBSCRIBER => $handler]);
    }

    /**
     * @param $handler e
     *
     * @return
     */
    public function unsubscribe($handler)
    {
        Test::ensureHandler($handler);
        $this->getMessageDispatcher()->disconnect($handler);
        $this->doFireEvent(
            self::EVENT_UNSUBSCRIBE,
            [
                self::HEADER_SUBSCRIBER => $handler,
            ]
        );
    }

    /**
     * @param $dispatcher
     * @param $transferListeners
     *
     * @return
     */
    public function setMessageDispatcher(\PEIP\INF\Dispatcher\Dispatcher $dispatcher, $transferListeners = true)
    {
        if (isset($this->dispatcher) && $transferListeners) {
            foreach ($this->dispatcher->getListeners() as $listener) {
                $dispatcher->connect($listener);
                $this->dispatcher->disconnect($listener);
            }
        }
        $this->dispatcher = $dispatcher;
        $this->doFireEvent(self::EVENT_SET_MESSAGE_DISPATCHER, [self::HEADER_DISPATCHER => $dispatcher]);
    }

    /**
     * @return
     */
    public function getMessageDispatcher()
    {
        $defaultDispatcher = self::DEFAULT_CLASS_MESSAGE_DISPATCHER;

        return isset($this->dispatcher) ? $this->dispatcher : $this->dispatcher = new $defaultDispatcher();
    }

    /**
     * @param string $commandName
     * @param $callable
     *
     * @return
     */
    protected function registerCommand($commandName, $callable)
    {
        $this->commands[$commandName] = $callable;
    }

    /**
     * @param $cmdMessage
     *
     * @return
     */
    public function command(\PEIP\INF\Message\Message $cmdMessage)
    {
        $this->doFireEvent(self::EVENT_PRE_COMMAND, [self::HEADER_MESSAGE => $cmdMessage]);
        $commandName = trim((string) $cmdMessage->getHeader('COMMAND'));
        if ($commandName != '' && array_key_exists($commandName, $this->commands)) {
            call_user_func($this->commands[$commandName], $cmdMessage->getContent());
        }
        $this->doFireEvent(self::EVENT_POST_COMMAND, [self::HEADER_MESSAGE => $cmdMessage]);
    }
}
