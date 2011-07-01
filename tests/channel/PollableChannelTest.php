<?php

require_once dirname(__FILE__).'/../../misc/bootstrap.php';
require_once dirname(__FILE__).'/../_files/NonBlockingPollableChannel.php';

class PollableChannelTest extends PHPUnit_Framework_TestCase { 

    protected $channelName = 'FOO';

    public function setup(){
        $this->channel = new \PEIP\Channel\PollableChannel($this->channelName);
    }

    public function testConstruct(){
        $this->assertTrue($this->channel instanceof \PEIP\INF\Channel\Channel);
    }

    public function testReceive(){
        $message = new \PEIP\Message\GenericMessage('Bar');
        $this->channel->send($message);
        $result = $this->channel->receive();
        $this->assertSame($message, $result);
    }


    public function testReceiveEmptyResult(){
        $result = $this->channel->receive();
        $this->assertFalse((bool)$result);
    }

    public function testReceiveTimeout(){
        $timeout = 5;
        $time1 = microtime(true);
        $message = new \PEIP\Message\GenericMessage('Bar');
        $this->channel->send($message);
        $result = $this->channel->receive($timeout);
        $time2 = microtime(true);
        $time3 = ((float)$time2-(float)$time1);
        $this->assertTrue((bool)$result);
        $this->assertTrue($time3<$timeout);
    }

    public function testReceiveTimeout2(){
        $timeout = 1;
        $time1 = microtime(true);
        $result = $this->channel->receive($timeout);
        $time2 = microtime(true);
        $time3 = ((float)$time2-(float)$time1);
        $this->assertFalse((bool)$result);
        $this->assertTrue($time3>$timeout);
    }

    public function testReceiveBlocking(){
        $channel = new NonBlockingPollableChannel('Bar');
        $message = new \PEIP\Message\GenericMessage('Bar');
        $channel->send($message);
        $result = $channel->receive(-1);
        $this->assertSame($message, $result);
    }

    public function testClear(){
        $message = new \PEIP\Message\GenericMessage('Bar');
        $this->channel->send($message);
        $this->channel->clear();
        $result = $this->channel->receive();
        $this->assertFalse((bool)$result);
    }


    public function testPurge(){
        $class = '\PEIP\Message\GenericMessage';
        $selector = new \PEIP\Selector\ContentClassSelector($class);
        $message = new \PEIP\Message\GenericMessage('Bar');
        $this->channel->send($message);
        $this->channel->purge($selector);
        $result = $this->channel->receive();
        $this->assertFalse((bool)$result);
    }

}

