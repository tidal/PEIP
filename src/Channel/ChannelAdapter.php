<?php

namespace PEIP\Channel;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP\Channel\ChannelAdapter
 * Abstract base class for all service activators
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP
 * @subpackage Channel
 */

class ChannelAdapter {

    protected $channel;
    protected $handler;

    public function __construct(\PEIP\ABS\Handler\MessageHandler $handler,  $channel){
        $this->channel = $channel;
        $this->handler = $handler;
    }

    protected function getMessage($object){
        if($this->channel instanceof \PEIP\INF\Channel\SubscribableChannel){
            return $object; 
        }else{
            return $object->getContent()->receive();
        }
    }

    public function handle($object){
        $message = $this->getMessage($object);
        if(!is_object($message)){
            throw new \Exception('Could not get Message from Channel');
        }
        $this->handler->handle($message);
    } 







}

